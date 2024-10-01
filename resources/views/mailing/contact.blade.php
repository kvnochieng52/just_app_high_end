<h1>Contact Form Submission</h1>

<p><strong>Name:</strong> {{ e($name) }}</p>
<p><strong>Email:</strong> {{ e($email) }}</p>
<p><strong>Telephone:</strong> {{ e($telephone) }}</p>
<p><strong>Message:</strong></p>
<p>{!! nl2br(e($userMessage)) !!}</p>