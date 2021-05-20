# Form submission notes (Laravel)

## Installation
- Clone the repo
- Run `composer install`
- Run `php artisan serve`
- Visit http://127.0.0.1:8000/enquiry or http://localhost:8000/enquiry


### 1) Attempt at validation

In the FormController, I added:

```python
$valid_data = $request->validate([
            'full_name' => 'required',
            'email_address' => 'required|email',
            'telephone_number' => 'numeric',
            'claim_type'=> 'required',
            'enquiry' => 'required',
            'agree_to_privacy_policy' => 'accepted',
        ]);
```

And in my version of `enquiry-form.blade.php` I added beneath each input field: 

```html
<small class="text-danger">{{ $errors->first('full_name') }}</small>
```

This worked, however if there is a mistake it will refresh on submit and remove all the contents from all fields, including ones with no errors - so I'll have a look at that and at getting a success alert when everything has worked!

### 2) Attempt at sending a notification email 

I took a look at Connexus Health and how it was done there. In the FormController, I added:

```python
$fields = [
            'Full Name' => $valid_data['full_name'],
            'Email' => $valid_data['email_address'],
            'Telephone' => $valid_data['telephone_number'],
            'Claim Type' => $valid_data['claim_type'],
            'Enquiry message' => $valid_data['enquiry'],
            'Agreed to privacy policy' => $valid_data['agree_to_privacy_policy'] ? 'Yes' : 'No',
        ];

        $type = 'Portal Claims Line enquiry';
        $recipients =  !empty(env('ENQUIRY_RECIPIENTS')) ? explode(',', env('ENQUIRY_RECIPIENTS')) : null;

        // Attempt sending the email with all data
        if(!empty($recipients)) {
            try {
                Mail::to($recipients)->send(new ContactMail($fields, $type));
                return back()->with('message_sent', 'Your message has been sent successfully');
            } catch(\Exception $e) {
                $error_email = true;
                Log::error('Error sending Business Form email: '.$e);
            }
        } else {
            Log::error('Could not send business enquiry email because no recipients were specified! (ENQUIRY_RECIPIENTS environment variable empty)');
        }
```

I updated `ENQUIRY_RECIPIENTS` with my email and updated all the MAIL_ variables to match other websites. I added ContactMail to App\Mail with a matching `blade` file. 

This didn't give errors but no email was sent on submit either. 

### 3) Thoughts on updating the CRM

Once an email is received, I'll look at updating the CRM. I've created a form in the CRM under PCL and I've updated the `CRM_CONTACT_FORM_URL` and `CRM_API_KEY` in the `.env` file! 

In other projects, it is done like this: 

```
    $crm_data = [
    'name' => $valid_data['full_name'],
    'company' => $valid_data['company_name'],
    'email' => $valid_data['email'],
    'telephone' => $valid_data['telephone'],
    'enquiry' => "(Redacted)",
    'agreed_to_privacy_policy' => ($valid_data['privacy_policy_check'] ? 'Yes' : 'No'),
    ];

    try {
        $this->guzzle->request('GET', env('CRM_BUSINESS_FORM_URL').'?token='.env('CRM_API_KEY').'&data='.urlencode(json_encode($crm_data)), [
            'verify' => false,
        ]);
    } catch(\Exception $e) {
        $error_crm = true;
        Log::error('Error sending data for the Business Form on CRM: '.$e);
    }
    
    // Return a successful response message back to the contact form
    return response()->json([
        'valid' => ($error_crm == true && $error_email == true ? false : true) 
    ]);
```

Which seems relatively okay! But I've not tackled that yet as I think getting the emails coming through is good to get sorted first. Then CRM, then success message maybe! I'm also not going to think about reCAPTCHA for now haha