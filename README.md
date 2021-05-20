# Basic form submission tutorial (Laravel)

## Installation
- Clone the repo
- Run `composer install`
- Run `php artisan serve`
- Visit http://127.0.0.1:8000/enquiry or http://localhost:8000/enquiry

## Tutorial

### 1) Create a controller to handle your form submissions
```
php artisan make:controller FormController
```
> ℹ "FormController" can be swapped out for whatever you want to call your controller

### 2) Add a method to handle a specific form

For this example, our `FormController` (class) will be responsible for handling all form submissions on our website.

Because we can potentially have multiple forms, each of them different, it would make sense to create a separate method to handle each form. 

Create a method in your new controller (/app/Http/Controllers/FormController.php). It should look something like this:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Handles the enquiry form submissions
     */
    public function enquiryForm(Request $request) {
        // Do something
    }
}
```
> ℹ `enquiryForm` can be swapped out for whatever name you like.

> ℹ The `$request` variable which we pass to the method will contain all of the data that is submitted from the form.

### 3) Make your new method accessible

In order for your form to be able to send its data to our new shiny controller and method, we need to add an entry for it in the routes.

Add the following to your **/routes/web.php** file

```php
Route::post('/submit/enquiry', [FormController::class, 'enquiryForm'])->name('submit.enquiry-form');
```
> ℹ Note that we're using `Route::post` instead of `Route::get` because we are "post"-ing data from our form

> ℹ The second parameter is an array which includes the controller we want to reference `FormController::class` followed by the name of the method we want to use `enquiryForm`

> ℹ Lastly, we add a name to the end of the route to easily reference it in our Blade files (use whatever you want here, as long as it makes sense!)

### 4) Tell your form where to post its data

Open the Blade file containing your form (/resources/views/enquiry-form.blade.php in this example) and update the opening `<form>` tag to POST to your new route:

```html
<form method="post" action="{{ route('submit.enquiry-form') }}">
```
> ℹ The value in the route function is what we used for the "name" property in the web routes file.

**Important "gotcha!":**

Now that our form knows where to send its data, we need a way to let Laravel know that the data that's being posted actually came from a trusted source (i.e. from this website). To do this, we use a [CSRF token](https://laravel.com/docs/8.x/csrf).

We can use a handy Blade directive which will automatically add a hidden CSRF token field to our form:

```html
<form method="post" action="{{ route('submit.enquiry-form') }}">
    @csrf

    <!-- Rest of our fields -->
</form>
```

### 5) Success! (Hopefully)

Now we can test our form. Fill it in and hit submit and the code in your method should spit out the contents of the form.

### Relevant files in this repo:

- **[FormController.php](https://github.com/dafroberts/laravel-basic-form/blob/master/app/Http/Controllers/FormController.php)** - Class (controller) responsible for handling all form submissions (contains our methods)
- **[web.php](https://github.com/dafroberts/laravel-basic-form/blob/master/routes/web.php)** - Contains all of our accessible URLs/routes
- **[enquiry-form.blade.php](https://github.com/dafroberts/laravel-basic-form/blob/master/resources/views/enquiry-form.blade.php)** - Contains the HTML markup for our form.



### 5) My attempt at validation

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

### 5) My attempt at sending a notification email 

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

Which seems relatively okay! 