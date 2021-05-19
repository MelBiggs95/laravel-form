<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Handles the enquiry form submissions
     */
    public function enquiryForm(Request $request) {
        // Spits out all the data we received from the form
        echo '<h2>All form data:</h2>';
        dump($request->all());

        // Spits out a specific field (name) from the form
        echo '<h2>Just the name field:</h2>';
        dump($request->input('name'));

        // TODO: validate the data

        // TODO: process the data, send an email? Submit it to a CRM?
    }
}
