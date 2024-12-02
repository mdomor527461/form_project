<!DOCTYPE html>
<html>
<head>
    <title>Customer and Bottling Details</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <h1>Customer Information</h1>
    <table>
        <tr><th>Winery</th><td>{{ $customer->winery }}</td></tr>
        <tr><th>Bottling Date</th><td>{{ $customer->bottling_date }}</td></tr>
        <tr><th>Address</th><td>{{ $customer->bottling_address }}</td></tr>
        <tr><th>City</th><td>{{ $customer->city }}</td></tr>
        <tr><th>ZIP</th><td>{{ $customer->zip }}</td></tr>
        <tr><th>Contact Person</th><td>{{ $customer->contact_person }}</td></tr>
        <tr><th>Contact Phone</th><td>{{ $customer->contact_phone }}</td></tr>
        <tr><th>Email</th><td>{{ $customer->email }}</td></tr>
        <tr><th>Power</th><td>{{ $customer->power }}</td></tr>
        <tr><th>Special Requirements</th><td>{{ $customer->special_requirements }}</td></tr>
    </table>

    <h1 class="text-center mt-5">Bottling Details</h1>
        @php
            // Split bottling details into chunks of 1 record per table for dynamic rendering
            $chunks = $bottling_details->chunk(1);
        @endphp

        @foreach ($chunks as $index => $chunk)
            <div class="table-container">
                <h3 class="text-center">Bottling Details {{ $index + 1 }}</h3>
                <table>
                    <!-- Dynamically create headers and values -->
                    @if ($chunk->count() > 0)
                        @php $detail = $chunk->first()->toArray(); @endphp
                        @foreach ($detail as $key => $value)
                            <tr>
                                <th>{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        @endforeach
    </div>


</body>
</html>
