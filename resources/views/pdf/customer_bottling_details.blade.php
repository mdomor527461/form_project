<!DOCTYPE html>
<html>

<head>
    <title>Customer and Bottling Details</title>
    <style>
        body {
            background-color: white;
            color: black;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
            color: black;
            padding: 5px;
        }

        th {
            background-color: white;
            color: #00aaff;
        }

        h1,
        h6,
        h5 {
            text-align: center;
            color: #ff4444;
        }

        .required {
            color: red;
        }

        .page-break {
            page-break-before: always;
        }

        /* Smaller font for tables */
        .bottling-details-table th,
        .bottling-details-table td {
            font-size: 8px;
            line-height: 1.2;
        }
    </style>
</head>

<body>
    <!-- Customer Information Section -->


    <!-- Bottling Details Section -->
    {{-- <div class="page-break"></div> --}}

    @php $wineNumber = 1; @endphp
    @foreach ($bottling_details->chunk(5) as $chunkIndex => $bottlingChunk)
        <div>
            <h5 class="text-center">Customer Information</h5>
            <table>
                <tr>
                    <th>Winery Name:</th>
                    <td>{{ $customer->winery }}</td>
                    <th>Bottling Address:</th>
                    <td>{{ $customer->bottling_address }}</td>
                </tr>
                <tr>
                    <th>Bottling Date:</th>
                    <td>{{ $customer->bottling_date }}</td>
                    <th>Contact Name:</th>
                    <td>{{ $customer->contact_person }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $customer->email }}</td>
                    <th>Phone:</th>
                    <td>{{ $customer->contact_phone }}</td>
                </tr>
                <tr>
                    <th>Power Supplied:</th>
                    <td colspan="3">{{ $customer->power }}</td>
                </tr>
            </table>
        </div>
        {{-- <h6>Table {{ $chunkIndex + 1 }}</h6> --}}
        <h5>bottling details</h5>
        <table class="bottling-details-table">
            <!-- Initialize wine counter -->

            <tr>
                <th>WINE</th>
                @foreach ($bottlingChunk as $detail)
                    <th>Wine #{{ $wineNumber }}</th>
                    @php $wineNumber++; @endphp <!-- Increment wine counter -->
                @endforeach
            </tr>
            <tr>
                <td>Service <span class="required">*</span></td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->service ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Brand Name</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->brand_name ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Year</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->year ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Variety</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->variety ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Volume</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->volume ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Tank</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->tank ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Pre-bottling Filtration</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->pre_bottling_filtration ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Filtration Bottling</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->filtration_bottling ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Gas Protection</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->gas_protection ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Bottle Type</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->bottle_type ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Manufacturer Code</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->manufacturer_code ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Bottle Color</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->bottle_color ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Bottle Size</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->bottle_size ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Closure Type</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->closure_type ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Labelling</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->labelling ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Label Height</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->label_height ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Sample Bottle</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->sample_bottle ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Packing Requirements</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->packing_requirements ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Cartoon</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->cartoon ?? '...' }}</td>
                @endforeach
            </tr>
        </table>

        <!-- Add a page break after each table except the last one -->
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>

</html>
