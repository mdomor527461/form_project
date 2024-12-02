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

    <h1>Bottling Details</h1>
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Brand Name</th>
                <th>Year</th>
                <th>Variety</th>
                <th>Volume</th>
                <th>Tank</th>
                <th>Filtration</th>
                <th>Bottle Type</th>
                <th>Bottle Size</th>
                <th>Closure Type</th>
                <th>Packing</th>
                <th>Cartoon</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bottling_details as $detail)
                <tr>
                    <td>{{ $detail->service }}</td>
                    <td>{{ $detail->brand_name }}</td>
                    <td>{{ $detail->year }}</td>
                    <td>{{ $detail->variety }}</td>
                    <td>{{ $detail->volume }}</td>
                    <td>{{ $detail->tank }}</td>
                    <td>{{ $detail->pre_bottling_filtration }}</td>
                    <td>{{ $detail->bottle_type }}</td>
                    <td>{{ $detail->bottle_size }}</td>
                    <td>{{ $detail->closure_type }}</td>
                    <td>{{ $detail->packing_requirements }}</td>
                    <td>{{ $detail->cartoon }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
