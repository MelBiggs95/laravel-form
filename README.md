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

- 