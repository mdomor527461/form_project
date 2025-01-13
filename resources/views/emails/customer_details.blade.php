<!DOCTYPE html>
<html>
<head>
    <title>MWP Bottling Details</title>
</head>
<body>
    <h1>MWP Bottling Details</h1>
    <p>Hi,</p>
    <p>Please find attached the bottling details for {{ $customer->winery }} on {{ \Carbon\Carbon::parse($customer->bottling_date)->format('d/m/Y') }}.</p>

    @if($reviewLink)
        <p>If you need to make any changes, you can do so by following this link:</p>
        <p><a href="{{ $reviewLink }}" style="color: blue; text-decoration: underline;">Review Bottling Details</a></p>
    @endif

    <p>Please don’t hesitate to reach out with any questions.</p>
    <br>
    <p>Kind regards,</p>
    <p>John & Karlie</p>
    <p>Mobile Wine Processing</p>
</body>
</html>
