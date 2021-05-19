<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Enquiry form</h1>

    <form method="post" action="{{ route('submit.enquiry-form') }}">
        @csrf

        <div>
            <input type="text" name="name" placeholder="Name">
        </div>

        <div>
            <input type="email" name="email" placeholder="Email address">
        </div>

        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
</body>
</html>