<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review and Update Your Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
        }

        h1 {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        fieldset {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        legend {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
        }

        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <h1>Review and Update Your Submitted Data</h1>

    <div class="form-container">
        <form action="{{ route('form.update', $customer->id) }}" method="POST" novalidate>
            @csrf
            @method('POST')

            <!-- Customer Information -->
            <h3 class="text-primary">Customer Information</h3>
            <div class="row">
                <div class="col-md-6 col-lg-4 form-group">
                    <label for="winery">Winery:</label>
                    <input type="text" class="form-control" id="winery" name="winery"
                        value="{{ $customer->winery }}" required>
                </div>
                <div class="col-md-6 col-lg-4 form-group">
                    <label for="bottling_date">Bottling Date:</label>
                    <input type="date" class="form-control w-100" id="bottling_date" name="bottling_date"
                        value="{{ $customer->bottling_date }}" required>
                </div>
                <div class="col-md-6 col-lg-4 form-group">
                    <label for="bottling_address">Bottling Address:</label>
                    <input type="text" class="form-control" id="bottling_address" name="bottling_address"
                        value="{{ $customer->bottling_address }}" required>
                </div>
                <div class="col-md-6 col-lg-4 form-group">
                    <label for="city">City:</label>
                    <input type="text" class="form-control" id="city" name="city"
                        value="{{ $customer->city }}" required>
                </div>
                <div class="col-md-6 col-lg-4 form-group">
                    <label for="zip">ZIP:</label>
                    <input type="text" class="form-control" id="zip" name="zip"
                        value="{{ $customer->zip }}" required>
                </div>
                <div class="col-md-6 col-lg-4 form-group">
                    <label for="contact_person">Contact Person:</label>
                    <input type="text" class="form-control" id="contact_person" name="contact_person"
                        value="{{ $customer->contact_person }}" required>
                </div>
                <div class="col-md-6 col-lg-4 form-group">
                    <label for="contact_phone">Contact Phone:</label>
                    <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                        value="{{ $customer->contact_phone }}" required>
                </div>
                <div class="col-md-6 col-lg-4 form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ $customer->email }}" required>
                </div>
                <div class="col-md-6 col-lg-4 form-group">
                    <label for="contact_email">Contact Email:</label>
                    <input type="email" class="form-control" id="contact_email" name="contact_email"
                        value="{{ $customer->contact_email }}" required>
                </div>
                <div class="col-md-6 col-lg-4 form-group">
                    <label for="power">Power:</label>
                    <input type="text" class="form-control" id="power" name="power"
                        value="{{ $customer->power }}" required>
                </div>
            </div>

            <!-- Bottling Details -->
            <h3 class="text-primary">Bottling Details</h3>
            @foreach ($bottlingDetails as $index => $detail)
                <fieldset>
                    <legend>Bottling Detail #{{ $index + 1 }}</legend>
                    <div class="row">
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="service_{{ $index }}">Service:</label>
                            <input type="text" class="form-control" id="service_{{ $index }}"
                                name="bottling_details[{{ $index }}][service]" value="{{ $detail->service }}"
                                required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="year_{{ $index }}">Year:</label>
                            <input type="text" class="form-control" id="year_{{ $index }}"
                                name="bottling_details[{{ $index }}][year]" value="{{ $detail->year }}"
                                required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="brand_name_{{ $index }}">Brand Name:</label>
                            <input type="text" class="form-control" id="brand_name_{{ $index }}"
                                name="bottling_details[{{ $index }}][brand_name]"
                                value="{{ $detail->brand_name }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="variety_{{ $index }}">Variety:</label>
                            <input type="text" class="form-control" id="variety_{{ $index }}"
                                name="bottling_details[{{ $index }}][variety]" value="{{ $detail->variety }}"
                                required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="volume_{{ $index }}">Volume:</label>
                            <input type="text" class="form-control" id="volume_{{ $index }}"
                                name="bottling_details[{{ $index }}][volume]" value="{{ $detail->volume }}"
                                required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="tank_{{ $index }}">Tank:</label>
                            <input type="text" class="form-control" id="tank_{{ $index }}"
                                name="bottling_details[{{ $index }}][tank]" value="{{ $detail->tank }}"
                                required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="pre_bottling_filtration_{{ $index }}">Pre-Bottling Filtration:</label>
                            <input type="text" class="form-control"
                                id="pre_bottling_filtration_{{ $index }}"
                                name="bottling_details[{{ $index }}][pre_bottling_filtration]"
                                value="{{ $detail->pre_bottling_filtration }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="filtration_bottling_{{ $index }}">Filtration Bottling:</label>
                            <input type="text" class="form-control" id="filtration_bottling_{{ $index }}"
                                name="bottling_details[{{ $index }}][filtration_bottling]"
                                value="{{ $detail->filtration_bottling }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="gas_protection_{{ $index }}">Gas Protection:</label>
                            <input type="text" class="form-control" id="gas_protection_{{ $index }}"
                                name="bottling_details[{{ $index }}][gas_protection]"
                                value="{{ $detail->gas_protection }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="bottle_type_{{ $index }}">Bottle Type:</label>
                            <input type="text" class="form-control" id="bottle_type_{{ $index }}"
                                name="bottling_details[{{ $index }}][bottle_type]"
                                value="{{ $detail->bottle_type }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="bottle_color_{{ $index }}">Bottle Color:</label>
                            <input type="text" class="form-control" id="bottle_color_{{ $index }}"
                                name="bottling_details[{{ $index }}][bottle_color]"
                                value="{{ $detail->bottle_color }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="bottle_size_{{ $index }}">Bottle Size:</label>
                            <input type="text" class="form-control" id="bottle_size_{{ $index }}"
                                name="bottling_details[{{ $index }}][bottle_size]"
                                value="{{ $detail->bottle_size }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="manufacturer_code_{{ $index }}">Manufacturer Code:</label>
                            <input type="text" class="form-control" id="manufacturer_code_{{ $index }}"
                                name="bottling_details[{{ $index }}][manufacturer_code]"
                                value="{{ $detail->manufacturer_code }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="closure_type_{{ $index }}">Closure Type:</label>
                            <input type="text" class="form-control" id="closure_type_{{ $index }}"
                                name="bottling_details[{{ $index }}][closure_type]"
                                value="{{ $detail->closure_type }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="closure_description_{{ $index }}">Closure Description:</label>
                            <input type="text" class="form-control" id="closure_description_{{ $index }}"
                                name="bottling_details[{{ $index }}][closure_description]"
                                value="{{ $detail->closure_description }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="apply_capsule_{{ $index }}">Apply Capsule:</label>
                            <input type="text" class="form-control" id="apply_capsule_{{ $index }}"
                                name="bottling_details[{{ $index }}][apply_capsule]"
                                value="{{ $detail->apply_capsule }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="capsule_description_{{ $index }}">Capsule Description:</label>
                            <input type="text" class="form-control" id="capsule_description_{{ $index }}"
                                name="bottling_details[{{ $index }}][capsule_description]"
                                value="{{ $detail->capsule_description }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="labelling_{{ $index }}">Labelling:</label>
                            <input type="text" class="form-control" id="labelling_{{ $index }}"
                                name="bottling_details[{{ $index }}][labelling]"
                                value="{{ $detail->labelling }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="sample_bottle_{{ $index }}">Sample Bottle:</label>
                            <input type="text" class="form-control" id="sample_bottle_{{ $index }}"
                                name="bottling_details[{{ $index }}][sample_bottle]"
                                value="{{ $detail->sample_bottle }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="label_height_{{ $index }}">Label Height:</label>
                            <input type="text" class="form-control" id="label_height_{{ $index }}"
                                name="bottling_details[{{ $index }}][label_height]"
                                value="{{ $detail->label_height }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="packing_requirements_{{ $index }}">Packing Requirements:</label>
                            <input type="text" class="form-control" id="packing_requirements_{{ $index }}"
                                name="bottling_details[{{ $index }}][packing_requirements]"
                                value="{{ $detail->packing_requirements }}" required>
                        </div>
                        <div class="col-md-6 col-lg-4 form-group">
                            <label for="cartoon_{{ $index }}">Cartoon:</label>
                            <input type="text" class="form-control" id="cartoon_{{ $index }}"
                                name="bottling_details[{{ $index }}][cartoon]"
                                value="{{ $detail->cartoon }}" required>
                        </div>
                    </div>
                </fieldset>
            @endforeach

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Update Details</button>
            </div>
        </form>
    </div>

    <!-- Trigger PDF download -->
    {{-- @if ($pdfPath)
      <script>
          window.onload = function() {
              const link = document.createElement('a');
              link.href = "{{ asset('storage/' . $pdfPath) }}";
              link.download = 'customer_bottling_details.pdf';
              link.click();
          };
      </script> --}}
    {{-- @endif --}}


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
