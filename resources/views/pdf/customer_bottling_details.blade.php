<!DOCTYPE html>
<html>

<head>
    <title>Customer and Bottling Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-TN3vx1B5bFPz3XiSG5iWrFub8BRsgvw3PQXQ0aTfEIt1RxI5N/V8Mz70nwdEn5oz" crossorigin="anonymous">
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
        h3,
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
            font-size: 12px;
            line-height: 0.8;
        }
    </style>
</head>

<body>
    <!-- Customer Information Section -->


    <!-- Bottling Details Section -->
    {{-- <div class="page-break"></div> --}}
    {{-- <h3>Mobline Wine Proccessing Form</h3> --}}
    @php $wineNumber = 1; @endphp
    @foreach ($bottling_details->chunk(5) as $chunkIndex => $bottlingChunk)
        <div style="width: 100%; display: table;">

            <!-- Left Section: MWP Content -->
            <div
                style="display: table-cell; width: 25%; vertical-align: top; border: 1px solid black; padding: 10px; text-align: center;">
                <h1 style="color: red; margin: 0;font-size:60px;">M<span style="color:#00aaff;">WP</span></h1>
                <p style="margin: 5px 0; font-size: 14px;">Mobile Wine Processing</p>
                <p style="margin: 0; font-size: 12px; font-style: italic;">The Estate Bottling Specialists</p>
            </div>

            <!-- Right Section: Customer Information -->
            <div style="display: table-cell; width: 75%; vertical-align: top; padding: 10px; border: 1px solid black;">
                <h5>Customer Information</h5>
                <table style="width: 100%; border-collapse: collapse;" class="bottling-details-table">
                    <tr>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;">Winery Name:</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->winery }}</td>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;">Bottling Date:</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->bottling_date }}</td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;">Bottling Address:</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->bottling_address }}</td>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;">Contact Name:</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->contact_person }}</td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;">Phone:</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->contact_phone }}</td>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;">Email:</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->email }}</td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;">Power</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->power }}</td>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;">Requirements</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->special_requirements }}</td>
                    </tr>
                </table>
            </div>

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
                <td>Year</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->year ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Brand Name</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->brand_name ?? '...' }}</td>
                @endforeach
            </tr>

            <tr>
                <td>Variety</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->variety ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Tank</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->tank ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Volume</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->volume ?? '...' }}</td>
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
                <td>Closure Type</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->closure_type ?? '...' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Packing Requirements</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->packing_requirements ?? '...' }}</td>
                @endforeach
            </tr>
        </table>

        <!-- Add a page break after each table except the last one -->
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qj/zlEZOed/1BEcZn3mTeUqSZXu/cz9VDP4hztKCPRZZ2Ik/G/bf5Ner/aVbWj2z" crossorigin="anonymous">
    </script>
</body>

</html>
