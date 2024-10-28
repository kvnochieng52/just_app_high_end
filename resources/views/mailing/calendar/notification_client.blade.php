<p>Hello <strong>{{ $client_name }}</strong>,</p>

<p>Your appointment request has been received with the following details:</p>

<table style="border-collapse: collapse; width: 100%; max-width: 600px;">
    <tr>
        <td style="padding: 4px 10px; font-weight: bold; width: 35%;">Owner/Agent/Company Name:</td>
        <td style="padding: 4px 10px;">{{ $created_by_name }}</td>
    </tr>
    <tr>
        <td style="padding: 4px 10px; font-weight: bold;">Property Name:</td>
        <td style="padding: 4px 10px;">{{ $property_name }}</td>
    </tr>
    <tr>
        <td style="padding: 4px 10px; font-weight: bold;">Date/Time:</td>
        <td style="padding: 4px 10px;">{{ $date }} {{ $time }}</td>
    </tr>
    <tr>
        <td style="padding: 4px 10px; font-weight: bold;">Location:</td>
        <td style="padding: 4px 10px;">{{ $location }}</td>
    </tr>
</table>

<p>For more details, please log in to the app.</p>

<p>
    <a href="{{ $calendar_link }}" target="_blank"
        style="display: inline-block; padding: 10px 15px; background-color: #4CAF50; color: #ffffff; text-decoration: none; border-radius: 5px;">Add
        to Calendar</a>
</p>