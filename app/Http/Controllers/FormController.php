<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{
    /**
     * Handles the enquiry form submissions
     */
    public function enquiryForm(Request $request) {
        // Spits out all the data we received from the form
        echo '<h2>All form data:</h2>';
        dump($request->all());

        // // Spits out a specific field (name) from the form
        echo '<h2>Just the name field:</h2>';
        dump($request->input('full_name'));


        // Validate the request
        $valid_data = $request->validate([
            'full_name' => 'required',
            'email_address' => 'required|email',
            'telephone_number' => 'numeric',
            'claim_type'=> 'required',
            'enquiry' => 'required',
            'agree_to_privacy_policy' => 'accepted',
        ]);


        // TODO: Process the data, send email
        

        // Prepare the fields for the email
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
                Log::error('Error sending Portal Claims email: '.$e);
            }
        } else {
            Log::error('Could not send contact enquiry email because no recipients were specified! (ENQUIRY_RECIPIENTS environment variable empty)');
        }

        // TODO: Give success message to user

        // TODO: Send data to CRM 
    }
}