<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Portal Claims Line Contact Form</title>
  </head>
  <body>
    <h1>Portal Claims Line</h1>
    <table class="table" width="100%" cellpadding="5" style="margin-bottom:25px">
      <thead>
        <tr>
          <th scope="col">Field</th>
          <th scope="col">Form Data</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">Name</th>
          <td>{{$fields['full_name']}}</td>
        </tr>
        <tr>
          <th scope="row">Email Address</th>
          <td>{{$fields['email_address']}}</td>
        </tr>
        <tr>
          <th scope="row">Phone Number</th>
          <td>{{$fields['telephone_number']}}</td>
        </tr>
        <tr>
          <th scope="row">Claim Type</th>
          <td>{{$fields['claim_type']}}</td>
        </tr>
        <tr>
          <th scope="row">Enquiry Message</th>
          <td>{{$fields['enquiry']}}</td>
        </tr>
        <tr>
          <th scope="row">Agreed to Privacy</th>
          <td>{{$fields['agree_to_privacy_policy']}}</td>
        </tr>
      </tbody>
    </table>

    <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
      <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">The information transmitted, including attachments, is intended only for the person(s) or entity to which it is addressed and may contain confidential and/or privileged material. Any review, retransmission, dissemination or other use of, or taking of any action in reliance upon this information by persons or entities other than the intended recipient is prohibited. If you received this in error please contact the sender and destroy any copies of this information.
    </td>
  </body>
</html>