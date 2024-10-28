<p>Hello {{ $created_by_name }}, </p>
<p>You have a new Appointment Request with the following details:</p>
<p><strong>Client Name:</strong> {{ $client_name }}</p>
<p><strong>Email:</strong> {{ $email }}</p>
<p><strong>Telephone:</strong> {{ $telephone }}</p>
<p><strong>Date/Time:</strong> {{ $date }} {{ $time }}</p>
<p><strong>Property Name:</strong> {{ $property_name }}</p>
<p>Please login to the app for more details.</p>

<p><a href="{{ $calendar_link }}" target="_blank">Add to Calendar</a></p>