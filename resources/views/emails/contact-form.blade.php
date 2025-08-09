<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Contact Form Submission</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111827; }
        .wrap { max-width: 600px; margin: 0 auto; padding: 16px; }
        .label { color: #6B7280; font-size: 12px; text-transform: uppercase; }
        .value { font-size: 14px; margin-bottom: 12px; }
    </style>
    </head>
<body>
<div class="wrap">
    <h2>New Contact Form Submission</h2>
    <p>You have received a new message from your website contact form.</p>

    <p class="label">Name</p>
    <p class="value">{{ trim(($data['first-name'] ?? '') . ' ' . ($data['last-name'] ?? '')) }}</p>

    <p class="label">Email</p>
    <p class="value">{{ $data['email'] ?? '' }}</p>

    @if(!empty($data['subject']))
        <p class="label">Subject</p>
        <p class="value">{{ $data['subject'] }}</p>
    @endif

    <p class="label">Message</p>
    <p class="value">{!! nl2br(e($data['message'] ?? '')) !!}</p>
</div>
</body>
</html>


