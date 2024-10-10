<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Form Created</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Hello, {{ $user->name }}!</h1>
        <p>Congratulations! You have successfully created a form named <strong>{{ $form->name }}</strong>.</p>
        <p><strong>Form Details:</strong></p>
        <ul>
            <li><strong>Form Slug:</strong> {{ $form->slug }}</li>
            <li><strong>Created At:</strong> {{ $form->created_at->format('F j, Y, g:i a') }}</li>
        </ul>
        <p>You can view or manage your form by clicking the link below:</p>
        <p><a href="{{ route('form.show', ['form_slug' => $form->slug]) }}">View Your Form</a></p>
        <p>If you have any questions or need assistance, feel free to reach out to us.</p>

        <div class="footer">
            <p>Thank you for using our service!</p>
            <p>The Team</p>
        </div>
    </div>
</body>

</html>