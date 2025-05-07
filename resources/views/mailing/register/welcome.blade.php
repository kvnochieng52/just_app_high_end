<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Just Homes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #4a90e2;
        }

        .content {
            font-size: 16px;
            line-height: 1.6;
        }

        .content a {
            color: #4a90e2;
            text-decoration: none;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .footer a {
            color: #4a90e2;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Just Homes!</h1>
        </div>
        <div class="content">
            <p>Dear {{$name}},</p>
            <p>We’re thrilled to have you join our community of home seekers and real estate enthusiasts. At Just Homes,
                we’re committed to helping you find your dream property and making your real estate
                journey as smooth as possible.</p>
            <p>Here’s what you can look forward to:</p>
            <ul>
                <li><strong>Browse Listings:</strong> Explore our extensive database of properties to find your perfect
                    match.</li>
                <li><strong>Save Favorites:</strong> Keep track of properties you love with our easy-to-use favorites
                    feature.</li>
                <li><strong>Get Alerts:</strong> Receive notifications about new listings and updates tailored to your
                    preferences.</li>
                <li><strong>Connect with Agents:</strong> Get expert advice and support from our experienced real estate
                    professionals.</li>
            </ul>
            <p>To get started, Login in to your account and begin your property
                search. If you have any questions or need assistance, our support team is always here to help.</p>
            <p>Thank you for choosing Just Homes. We’re excited to be part of your home buying journey!
            </p>
        </div>
        <div class="footer">
            <p>Best regards,<br>
                The Just Homes Team</p>
            <p><a href="mailto:support@justhomesapp.com">Contact Us</a></a>
            </p>
        </div>
    </div>
</body>

</html>