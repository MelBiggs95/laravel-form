<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends('layouts.default')
@section('content')
{{-- Contact Banner --}}
	<section class="banner-inner bg-pcl-blue d-flex">	
		<div class="container align-self-center">
			<div class="row px-3 px-sm-5 banner-contact-content">
				<div class="content col-12 mt-sm-0 mt-md-4">
			
					<h2 class="banner-heading">Start your claim</h2>

					<p class="banner-text text-white pt-1 pb-4">Contact us now to get started on your injury compensation claim</p>

				</div>
			</div>
		</div>
	</section>

{{-- Contact Content --}}
    <section class="main-content contact-form pt-5 pb-5">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<form name="contact-us" id="contact-form" method="post" action="{{ route('submit.enquiry-form') }}" class="contact-form">
						@csrf
						@if(Session::has('message_sent'))
							<div class="alert alert-success" role="alert">
								{{Session::get('message_sent')}}
							</div>
						@endif
						<p class="contact-heading pt-4 pb-4">Your details</p>
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="form-group contact-form__field-container">
									<label for="id_fullname">Full name*</label>
									<input type="text" id="id_fullname" name="full_name" class="form-control contact-form__field-container__field">
									<small class="text-danger">{{ $errors->first('full_name') }}</small>
								</div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="form-group contact-form__field-container">
									<label for="id_email">Email*</label>
									<input type="email" id="id_email" name="email_address" class="form-control contact-form__field-container__field">
									<small class="text-danger">{{ $errors->first('email_address') }}</small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="form-group contact-form__field-container">
									<label for="id_telephone">Telephone*</label>
									<input type="text" id="id_telephone" name="telephone_number" class="form-control contact-form__field-container__field">
									<small class="text-danger">{{ $errors->first('telephone_number') }}</small>
								</div>
							</div>
						</div>
						<p class="contact-heading pt-4 pb-4">Your claim</p>
						<div class="row">
							<div class="form-group col-sm-12 col-md-6 contact-form__field-container">
								<label for="claim_type">Type of claim</label>
								<select id="claim_type" class="form-control" name="claim_type">
									<option selected></option>
									<option>Road Traffic Accident</option>
									<option>Accident at work</option>
									<option>Slips, trips & falls</option>
									<option>Vulnerable Road User</option>
									<option>Medical Negligence</option>
								</select>
								<small class="text-danger">{{ $errors->first('claim_type') }}</small>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group contact-form__field-container">
									<label for="id_enquiry">Additional information about your claim</label>
									<textarea id="id_enquiry" name="enquiry" class="form-control contact-form__field-container__field"></textarea>
									<small class="text-danger">{{ $errors->first('enquiry') }}</small>
								</div>
							</div>
						</div>
						<div class="row pt-3 pb-5">
							<div class="col-sm-12">
								<div class="form-check contact-form__field-container">
									<input type="checkbox" class="form-check-input" id="agree_to_privacy_policy" name="agree_to_privacy_policy">
									<label class="form-check-label" for="agree_to_privacy_policy">I have read and agree to the <a href="/privacy-policy" target="_blank">Privacy Policy</a></label>
									<br><small class="text-danger">{{ $errors->first('agree_to_privacy_policy') }}</small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div id='recaptcha' class="g-recaptcha" data-sitekey="6Ley0ykUAAAAAJx1nuIO1dkQqQLhtj5kKkhyBG-L" data-callback="onSubmit" data-size="invisible"></div>
								<input type="submit" class="btn btn-pcl-blue text-white px-4 float-right" />
							</div>
						</div>
					</form>
				</div>

				<div class="col-md-12 col-lg-4 contact-sidebar">
					<div class="row float-md-right align-sm-center">
						<div class="col-12">
							<div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
								<div class="card-body m-3">
									<p class="card-heading">Prefer to talk?</p>
									<p class="card-text"><span class="callback">Request a call back</span> or drop us a line on the number below and one of our helpful team members will be happy to help.</p>
									<p class="card-telephone"><a href="tel:0300 3033 637" class="d-lg-none text-decoration-none text-warning">0300 3033 637</a><span class="d-none d-lg-block">0300 3033 637</span><p>
									<p class="card-small">Lines open between 9:00am and 6:00pm Monday to Friday. 10:00am to 4:00pm Saturday and Sunday.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>