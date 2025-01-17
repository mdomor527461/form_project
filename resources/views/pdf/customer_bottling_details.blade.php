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
            text-align: left;
            color: black;
            padding: 5px;
        }

        th {
            background-color: white;
            color: blue;

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
            font-size: 16px;
            line-height: 1;
        }
    </style>
</head>

<body>
    <!-- Customer Information Section -->


    <!-- Bottling Details Section -->
    {{-- <div class="page-break"></div> --}}
    {{-- <h3>Mobline Wine Proccessing Form</h3> --}}
    @php $wineNumber = 1;

    @endphp
    @foreach ($bottling_details->chunk(5) as $chunkIndex => $bottlingChunk)
        <div style="width: 100%; display: table;">

            <!-- Left Section: MWP Content -->
            <div
                style="display: table-cell; width: 25%; vertical-align: bottom; padding: 10px;padding-bottom:15px; text-align: center;">
                {{-- <h1 style="color: red; margin: 0;font-size:60px;">M<span style="color:blue;">WP</span></h1>
                <p style="margin: 5px 0; font-size: 14px;">Mobile Wine Processing</p>
                <p style="margin: 0; font-size: 12px; font-style: italic;">The Estate Bottling Specialists</p> --}}
                <img src="{{public_path('img/logo/MWP_Logo-1536x759.jpg')}}" alt="" style="width:200px;">
            </div>

            <!-- Right Section: Customer Information -->
            <div style="display: table-cell; width: 75%; vertical-align: top; padding: 10px;margin-right:-30px">
                <table style="width: 100%; border-collapse: collapse;" class="bottling-details-table">
                    <tr>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;color:black; font-weight: 400;">Winery Name:</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->winery ?? "..." }}</td>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;color:black; font-weight: 400;">Bottling Date:</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->bottling_date ?? "..." }}</td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;color:black; font-weight: 400;">Bottling Address:</th>
                        <td style="border: 1px solid black; padding: 5px;" colspan="3">{{ $customer->bottling_address ?? "..." }}</td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;color:black; font-weight: 400;">Contact Name:</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->contact_person ?? "..." }}</td>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;color:black; font-weight: 400;">Phone:</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->contact_phone ?? "..." }}</td>

                    </tr>
                    <tr>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;color:black; font-weight: 400;">Email:</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->email ?? "..." }}</td>
                        <th style="border: 1px solid black; padding: 5px; text-align: left;color:black; font-weight: 400;">Power Supply</th>
                        <td style="border: 1px solid black; padding: 5px;">{{ $customer->power ?? "..." }}</td>
                    </tr>
                </table>
            </div>

        </div>


        {{-- <h6>Table {{ $chunkIndex + 1 }}</h6> --}}
        <table class="bottling-details-table" style="width: 100%; table-layout: fixed; border-collapse: collapse;">
            <!-- Initialize wine counter -->

            <tr>
                <th style="text-align: left; width: 20%;">WINE</th>
                @for ($i = 0; $i < 5; $i++)
                    <th style="width: 16%;">Wine #{{ $wineNumber++ }}</th>
                @endfor
            </tr>
            <tr>
                <td>Service</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->service ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                        <td></td>
                @endfor
            </tr>

            <tr>
                <td>Brand</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->brand_name ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Year</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->year ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Variety</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->variety ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Volume (Litres)</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->volume ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Tank/Vessel</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->tank ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr style="background-color: rgb(239, 225, 225)">
                <td style="color:blue">FILTRATION</td>
                @foreach ($bottlingChunk as $detail)
                    <td></td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Current Filtraton</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->pre_bottling_filtration ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Required Filtration </td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->filtration_bottling ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Gas Protection ?</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->gas_protection ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>

            <tr style="background-color: rgb(239, 225, 225)">
                <td style="color:blue">BOTTLE</td>
                @foreach ($bottlingChunk as $detail)
                    <td></td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Type</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->bottle_type ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Code</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->manufacturer_code ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Color</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->bottle_color ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Size</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->bottle_size ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr style="background-color: rgb(239, 225, 225)">
                <td style="color:blue">CLOSURE</td>
                @foreach ($bottlingChunk as $detail)
                    <td></td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Type</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->closure_type ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Description</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->closure_description ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Capsule (cork only)</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->apply_capsule ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Capsule Description</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->capsule_description ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>

            <tr style="background-color: rgb(239, 225, 225)">
                <td style="color:blue">LABALING</td>
                @foreach ($bottlingChunk as $detail)
                    <td></td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>

                <td>Type</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->labelling ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
             <tr>

                <td>Height</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->label_height ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
             <tr>
                @php
                if($detail->sample_bottle == 1 || $detail->sample_bottle == 'yes' || $detail->sample_bottle == 'Yes'){
                    $sample = 'Yes';
                }
                else if($detail->sample_bottle == 0 || $detail->sample_bottle == 'no' || $detail->sample_bottle == 'No'){
                    $sample = 'No';;
                }
                @endphp
                <td>Sample Available ? </td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $sample ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>

            <tr style="background-color: rgb(239, 225, 225)">
                <td style="color:blue">PACKAGING</td>
                @foreach ($bottlingChunk as $detail)
                    <td></td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Type</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->packing_requirements ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Message</td>
                @foreach ($bottlingChunk as $detail)
                    <td>{{ $detail->cartoon ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                <td></td>
                @endfor
            </tr>
            <tr>
                <td>Bottles (office use only)</td>
                @foreach ($bottlingChunk as $detail)
                    @php
                        if ($detail->bottle_size == '750ml') {
                            $bottles = round(($detail->volume * 1000) / 750); // 750ml বোতলের জন্য
                        } elseif ($detail->bottle_size == '375ml') {
                            $bottles = round(($detail->volume * 1000) / 375); // 375ml বোতলের জন্য
                        } else {
                            $bottles = round(($detail->volume * 1000) / (int) $detail->bottle_size); // অন্য সাইজের বোতলের জন্য
                        }
                    @endphp
                    <td>{{ $bottles ?? '...' }}</td>
                @endforeach
                @for ($i = $bottlingChunk->count(); $i < 5; $i++)
                    <td></td>
                @endfor
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
