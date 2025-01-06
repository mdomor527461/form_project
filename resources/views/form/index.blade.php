<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Wine Processing Booking Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">




</head>

<body style="background-color:antiquewhite;">
    <div class="mb-4">
        {{-- <div class="text-center">
            <h1 class="mt-5 mb-5">MWP Booking Form</h1>
        </div> --}}
        <form action="{{ route('form.store') }}" method="POST" style="background-color: white;padding:20px" novalidate>
            @csrf
            <!-- Customer Information -->
            <h3 style="margin-left:20px;">Booking Form</h3>
            {{-- <p style="margin-left:20px;">" *" indicates required fields</p> --}}
            <div class="section-container">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="winery" class="form-label">Winery Name *</label>
                        <input type="text" id="winery" name="winery" class="form-control" required>

                    </div>
                    <div class="col-md-6">
                        <label for="bottling-date" class="form-label">Confirmed Bottling Date *</label>
                        <input type="date" id="bottling-date" name="bottling_date" class="form-control " required>

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="bottling-address" class="form-label">Address *</label>
                        <input type="text" id="bottling-address" name="bottling_address" class="form-control "
                            required>
                        <small>Street Adress</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="city" name="city" class="form-control mt-2 " required>
                        <small>City/Locality</small>
                        <br>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="zip" name="zip" class="form-control mt-2 " required>
                        <small>Post Code</small>
                    </div>
                </div>
                <div class="row mb-3" style="margin-top:-10px;">

                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="contact-person" class="form-label">Winemaker / Contact person *</label>
                        <input type="text" id="contact-person" name="contact_person" class="form-control " required>

                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" id="email" name="email" class="form-control " required>

                    </div>
                    <div class="col-md-4">
                        <label for="contact-phone" class="form-label">Phone *</label>
                        <input type="text" id="contact-phone" name="contact_phone" class="form-control " required>

                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="email" class="form-label">Accounts Email </label>
                        <input type="email" id="email" name="contact_email" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="power" class="form-label">Power Supply *</label>
                        <select id="power" name="power" class="form-select " required>
                            <option value="">Please select</option>
                            <option value="Single Phase">Power Supplied (3 Amp, 5 Pin)</option>
                            <option value="MWP Generator">MWP Generator required</option>
                        </select>

                    </div>
                </div>
            </div>

            <!-- Bottling Details -->
            <h3 class="section-title" style="margin-left:20px;color:black;">Bottling Details</h3>
            <div class="section-container">
                <div id="product-list"></div>
                <button type="button" class="btn btn-add btn-sm" id="add-product">+ Add Wine</button>
                <button type="submit" class="btn btn-submit mb-2 mx-5">Submit</button>
            </div>


        </form>

        @if (session('store_success'))
            <div class="alert alert-success">
                {{ session('store_success') }}
            </div>
        @endif

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




    <script>
        document.getElementById("bottling-date").addEventListener("click", function() {
            this.showPicker(); // Ensures the calendar picker is displayed.
        });

        let wineCounter = 1; // Initialize wine counter

        document.getElementById('add-product').addEventListener('click', function() {
            const productList = document.getElementById('product-list');
            // Add the initial product container
            const productContainer = document.createElement('div');
            productContainer.className = 'product-item mb-3 p-3 border rounded';
            productContainer.innerHTML = `
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between align-items-center mb-2">
                    <h4 style="font-weigh:bold;">Item#${wineCounter}</h4> <!-- Dynamic wine title -->
                    <button type="button" class="btn-close btn-sm"></button>
                </div>
                </div>
                <div>
                    <label class="form-label">Service Required  *</label>
                <div class="col-md-4">
                    <select id="service-${wineCounter}" name="bottling_details[${wineCounter}][service]" class="form-select" required>
                        <option value="" >Please select</option>
                        <option value="FillLabelPack">Fill, Label, Pack</option>
                        <option value="FillPack">Fill, Pack</option>
                        <option value="LabelPack">Label, Pack</option>
                    </select>
                </div>

                </div>
                <div class="fields mt-3"></div>
            `;

            productList.appendChild(productContainer);

            // Increment the wine counter
            wineCounter++;

            // Handle dynamic fields based on selection
            productContainer.addEventListener('change', function(e) {
                if (e.target.value.endsWith("Pack")) {
                    const fields = productContainer.querySelector('.fields');
                    fields.innerHTML = ''; // Clear previous fields

                    // Add fields based on selection
                    if (e.target.value === 'FillLabelPack') {
                        fields.innerHTML = `
                            <h5 class="section-title">Wine</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="year" class="form-label">Year  *</label>
                                        <input type="number" id="year" name="bottling_details[${wineCounter}][year]" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="brand-name" class="form-label">Brand Name  *</label>
                                        <input type="text" id="brand-name" name="bottling_details[${wineCounter}][brand_name]" class="form-control"required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="variety" class="form-label">Variety/Name  *</label>
                                        <input type="text" id="variety" name="bottling_details[${wineCounter}][variety]" class="form-control"  required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="tank" class="form-label">Volume(litres)</label>
                                        <input type="number" id="tank" name="bottling_details[${wineCounter}][volume]" class="form-control" >
                                    </div>
                                      <div class="col-md-4">
                                        <label for="tank" class="form-label">Tank/Vessel Identifier</label>
                                        <input type="text" id="tank" name="bottling_details[${wineCounter}][tank]" class="form-control" >
                                    </div>
                                </div>
                                <h5 class="section-title">FILTRATION</h5>
                                <div class="row mb-3">
                                     <div class="col-md-4">
                                        <label for="pre-bottling-filtration" class="form-label">Pre Bottling Filtration  *</label>
                                        <select id="pre-bottling-filtration" name=" bottling_details[${wineCounter}][pre_bottling_filtration]" class="form-select" required>
                                            <option value="">Please select</option>
                                            <option value="CrossFlow">CrossFlow</option>
                                            <option value="Rack">Rack</option>
                                            <option value="None">None</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="filtration-bottling" class="form-label">Filtration Required at Bottling  *</label>
                                        <select id="filtration-bottling" name="bottling_details[${wineCounter}][filtration_bottling]"  class="form-select" required>
                                            <option value="">Please select</option>
                                            <option value="None">None - (Pump filter only)</option>
                                            <option value="300">300 Lenticular (6-12um Polishing filtration)</option>
                                            <option value="EK">EK Lenticular (.45um nominal)</option>
                                            <option value="Sterile">Sterile (.45um absolute)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="filtration-bottling" class="form-label">Gas Protection  *</label>
                                        <select id="gas-protection" name="bottling_details[${wineCounter}][gas_protection]"  class="form-select" required>
                                            <option value="">Please select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <h5 class="section-title">Bottle</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="bottle-type-${wineCounter}" class="form-label">Bottle Type  *</label>
                                        <select id="bottle-type-${wineCounter}" name="bottling_details[${wineCounter}][bottle_type]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="Riesling">Riesling</option>
                                            <option value="Punted Burgundy">Punted Burgundy</option>
                                            <option value="Premium Burgundy">Premium Burgundy</option>
                                            <option value="Square Heel Burgundy">Square Heel Burgundy</option>
                                            <option value="Punted Claret">Punted Claret</option>
                                            <option value="Premium Claret">Premium Claret</option>
                                            <option value="Super Premium Claret">Super Premium Claret</option>
                                            <option value="Atlas">Atlas</option>
                                            <option value="Epic">Epic</option>
                                            <option value="Odeon">Odeon</option>
                                            <option value="Classique">Classique</option>

                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="bottle-color" class="form-label">Colour *</label>
                                        <select id="bottle-color-${wineCounter}" name="bottling_details[${wineCounter}][bottle_color]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="Flint">Flint</option>
                                            <option value="Antique Green">Antique Green</option>
                                            <option value="French Green">French Green</option>
                                            <option value="Amber">Amber</option>
                                            <option value="Arctic Blue">Arctic Blue</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="bottle-size" class="form-label">Size *</label>
                                        <select id="bottle-size-${wineCounter}" name="bottling_details[${wineCounter}][bottle_size]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="750ml">750ml</option>
                                            <option value="375ml">375ml</option>
                                            <option value="Other">Other (Please specify)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4" id="man-pre-${wineCounter}" style="display:block;">
                                        <label for="manufacturer-code-${wineCounter}" class="form-label">Manufacturers Product Code</label>
                                        <input type="text" id="manufacturer-code-${wineCounter}" name="bottling_details[${wineCounter}][manufacturer_code]" class="form-control" >
                                    </div>
                                    <div class="col-md-4" id="color-other-${wineCounter}" style="display:none;">
                                        <label for="color_other" class="form-label">Please Specify Bottle Colour</label>
                                        <input type="text" name="bottling_details[${wineCounter}][bottle_color_other]" class="form-control">
                                    </div>
                                    <div class="col-md-4" id="size-other-${wineCounter}" style="display:none;">
                                        <label for="color_other" class="form-label">Please Specify Bottle Size</label>
                                        <input type="number" name="bottling_details[${wineCounter}][bottle_size_other]" class="form-control">
                                    </div>
                                    <div class="col-md-4" id="man-aft-${wineCounter}" style="display:none;">
                                        <label for="manufacturer-code-${wineCounter}" class="form-label">Manufacturers Product Code</label>
                                        <input type="text" id="manufacturer-code-${wineCounter}" name="bottling_details[${wineCounter}][manufacturer_code]" class="form-control" >
                                    </div>
                                </div>

                                <h5 class="section-title">Closure </h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="closure-type" class="form-label">Closure Type  *</label>
                                        <select id="closure-type-${wineCounter}" name="bottling_details[${wineCounter}][closure_type]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="30mm Screwcap">30mm Screwcap</option>
                                            <option value="31mm Screwcap">31mm Screwcap</option>
                                            <option value="Natural-Cork">Natural Cork</option>
                                            <option value="Diam 5">Diam 5</option>
                                            <option value="Diam 10">Diam 10</option>
                                            <option value="Diam 15">Diam 15</option>
                                            <option value="Diam 20">Diam 20</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="other-input-container col-md-4"></div>
                                    <div id="apply-capsule-${wineCounter}" class="col-md-4" style="display:none">
                                    <label for="apply_capsule" class="form-label">Apply Capsule *</label>
                                    <select name="bottling_details[${wineCounter}][apply_capsule]" class="form-select apply-capsule-dropdown">
                                        <option value="">Please select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="row mb-3">

                                    <div id="capsule-description-${wineCounter}" class="col-md-4" style="display:none">
                                         <label for="bottling_details[${wineCounter}][capsule_description]" class="form-label">Capsule Description *</label>
                                        <input type="text" name="bottling_details[${wineCounter}][capsule_description]" class="form-control" placeholder="Colour, Branding etc">
                                    </div>
                                </div>

                                <h5 class="section-title">LABEL</h5>
                                <div class="row mb-3">
                                    <div  class="col-md-4" >
                                    <label for="labeling_type" class="form-label">Type *</label>
                                    <select name="bottling_details[${wineCounter}][labeling]" class="form-select apply-capsule-dropdown" required>
                                       <option value="">Please select</option>
                                        <option value="Wrap">Wrap</option>
                                        <option value="Front & Back - Separate reels">Front & Back - Separate reels</option>
                                        <option value="Front & Back - Same reel">Front & Back - Same reel</option>
                                        <option value="Front only">Front only</option>
                                        <option value="Back only">Back only</option>
                                        <option value="None">None</option>
                                    </select>
                                    </div>
                                    <div  class="col-md-4" >
                                    <label for="sample_bottle" class="form-label">Sample bottle available? *</label>
                                    <select name="bottling_details[${wineCounter}][sample_bottle]" class="form-select apply-capsule-dropdown" required>
                                        <option value="">Please select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    </div>
                                     <div class="col-md-4">
                                         <label for="bottling_details[${wineCounter}][label_height]" class="form-label">Label Height (in milimeters) </label>
                                        <input type="text" name="bottling_details[${wineCounter}][label_height]" class="form-control" placeholder="Bottom of bottle to bottom of label">
                                    </div>
                                </div>

                                <h5 class="section-title">Packaging</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="packing-requirements" class="form-label">Type  *</label>
                                        <select id="packing-requirements-${wineCounter}" name="bottling_details[${wineCounter}][packing_requirements]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="Branded Standup 12">Branded Standup 12</option>
                                            <option value="Branded Standup 6">Branded Standup 6</option>
                                            <option value="Branded Laydown 12 (2x6)">Branded Laydown 12 (2x6)</option>
                                            <option value="Branded Laydown 6 (2x3)">Branded Laydown 6 (2x3)</option>
                                            <option value="Branded Laydown 6 (1x6)">Branded Laydown 6 (1x6)</option>
                                            <option value="Plain Standup 12">Plain Standup 12</option>
                                            <option value="Plain Standup 6">Plain Standup 6</option>
                                            <option value="Plain Laydown 12 (2x6)">Plain Laydown 12 (2x6)</option>
                                            <option value="Plain Laydown 6 (2x3)">Plain Laydown 6 (2x3)</option>
                                            <option value="Plain Laydown 6 (1x6)">Plain Laydown 6 (1x6)</option>
                                            <option value="Cellar Stacks">Cellar Stacks</option>
                                            <option value="Bins">Bins</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="other-input-container col-md-4"></div>
                                </div>
                            `;
                    } else if (e.target.value === 'FillPack') {
                        fields.innerHTML = `
                                 <h5 class="section-title">Wine</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="year" class="form-label">Year  *</label>
                                        <input type="number" id="year" name="bottling_details[${wineCounter}][year]" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="brand-name" class="form-label">Brand Name  *</label>
                                        <input type="text" id="brand-name" name="bottling_details[${wineCounter}][brand_name]" class="form-control"required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="variety" class="form-label">Variety/Name  *</label>
                                        <input type="text" id="variety" name="bottling_details[${wineCounter}][variety]" class="form-control"  required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="tank" class="form-label">Volume(litres)</label>
                                        <input type="number" id="tank" name="bottling_details[${wineCounter}][volume]" class="form-control" >
                                    </div>
                                      <div class="col-md-4">
                                        <label for="tank" class="form-label">Tank/Vessel Identifier</label>
                                        <input type="text" id="tank" name="bottling_details[${wineCounter}][tank]" class="form-control" >
                                    </div>
                                </div>
                                <h5 class="section-title">FILTRATION</h5>
                                <div class="row mb-3">
                                     <div class="col-md-4">
                                        <label for="pre-bottling-filtration" class="form-label">Pre Bottling Filtration  *</label>
                                        <select id="pre-bottling-filtration" name=" bottling_details[${wineCounter}][pre_bottling_filtration]" class="form-select" required>
                                            <option value="">Please select</option>
                                            <option value="CrossFlow">CrossFlow</option>
                                            <option value="Rack">Rack</option>
                                            <option value="None">None</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="filtration-bottling" class="form-label">Filtration Required at Bottling  *</label>
                                        <select id="filtration-bottling" name="bottling_details[${wineCounter}][filtration_bottling]"  class="form-select" required>
                                            <option value="">Please select</option>
                                            <option value="None">None - (Pump filter only)</option>
                                            <option value="300">300 Lenticular (6-12um Polishing filtration)</option>
                                            <option value="EK">EK Lenticular (.45um nominal)</option>
                                            <option value="Sterile">Sterile (.45um absolute)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="filtration-bottling" class="form-label">Gas Protection  *</label>
                                        <select id="gas-protection" name="bottling_details[${wineCounter}][gas_protection]"  class="form-select" required>
                                            <option value="">Please select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <h5 class="section-title">Bottle</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="bottle-type-${wineCounter}" class="form-label">Bottle Type  *</label>
                                        <select id="bottle-type-${wineCounter}" name="bottling_details[${wineCounter}][bottle_type]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="Riesling">Riesling</option>
                                            <option value="Punted Burgundy">Punted Burgundy</option>
                                            <option value="Premium Burgundy">Premium Burgundy</option>
                                            <option value="Square Heel Burgundy">Square Heel Burgundy</option>
                                            <option value="Punted Claret">Punted Claret</option>
                                            <option value="Premium Claret">Premium Claret</option>
                                            <option value="Super Premium Claret">Super Premium Claret</option>
                                            <option value="Atlas">Atlas</option>
                                            <option value="Epic">Epic</option>
                                            <option value="Odeon">Odeon</option>
                                            <option value="Classique">Classique</option>

                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="bottle-color" class="form-label">Colour *</label>
                                        <select id="bottle-color-${wineCounter}" name="bottling_details[${wineCounter}][bottle_color]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="Flint">Flint</option>
                                            <option value="Antique Green">Antique Green</option>
                                            <option value="French Green">French Green</option>
                                            <option value="Amber">Amber</option>
                                            <option value="Arctic Blue">Arctic Blue</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="bottle-size" class="form-label">Size *</label>
                                        <select id="bottle-size-${wineCounter}" name="bottling_details[${wineCounter}][bottle_size]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="750ml">750ml</option>
                                            <option value="375ml">375ml</option>
                                            <option value="Other">Other (Please specify)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4" id="man-pre-${wineCounter}" style="display:block;">
                                        <label for="manufacturer-code-${wineCounter}" class="form-label">Manufacturers Product Code</label>
                                        <input type="text" id="manufacturer-code-${wineCounter}" name="bottling_details[${wineCounter}][manufacturer_code]" class="form-control" >
                                    </div>
                                    <div class="col-md-4" id="color-other-${wineCounter}" style="display:none;">
                                        <label for="color_other" class="form-label">Please Specify Bottle Colour</label>
                                        <input type="text" name="bottling_details[${wineCounter}][bottle_color_other]" class="form-control">
                                    </div>
                                    <div class="col-md-4" id="size-other-${wineCounter}" style="display:none;">
                                        <label for="color_other" class="form-label">Please Specify Bottle Size</label>
                                        <input type="number" name="bottling_details[${wineCounter}][bottle_size_other]" class="form-control">
                                    </div>
                                    <div class="col-md-4" id="man-aft-${wineCounter}" style="display:none;">
                                        <label for="manufacturer-code-${wineCounter}" class="form-label">Manufacturers Product Code</label>
                                        <input type="text" id="manufacturer-code-${wineCounter}" name="bottling_details[${wineCounter}][manufacturer_code]" class="form-control" >
                                    </div>
                                </div>

                                <h5 class="section-title">Closure </h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="closure-type" class="form-label">Closure Type  *</label>
                                        <select id="closure-type-${wineCounter}" name="bottling_details[${wineCounter}][closure_type]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="30mm Screwcap">30mm Screwcap</option>
                                            <option value="31mm Screwcap">31mm Screwcap</option>
                                            <option value="Natural-Cork">Natural Cork</option>
                                            <option value="Diam 5">Diam 5</option>
                                            <option value="Diam 10">Diam 10</option>
                                            <option value="Diam 15">Diam 15</option>
                                            <option value="Diam 20">Diam 20</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="other-input-container col-md-4"></div>
                                    <div id="apply-capsule-${wineCounter}" class="col-md-4" style="display:none">
                                    <label for="apply_capsule" class="form-label">Apply Capsule *</label>
                                    <select name="bottling_details[${wineCounter}][apply_capsule]" class="form-select apply-capsule-dropdown">
                                        <option value="">Please select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="row mb-3">

                                    <div id="capsule-description-${wineCounter}" class="col-md-4" style="display:none">
                                         <label for="bottling_details[${wineCounter}][capsule_description]" class="form-label">Capsule Description *</label>
                                        <input type="text" name="bottling_details[${wineCounter}][capsule_description]" class="form-control" placeholder="Colour, Branding etc">
                                    </div>
                                </div>



                                <h5 class="section-title">Packaging</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="packing-requirements" class="form-label">Type  *</label>
                                        <select id="packing-requirements-${wineCounter}" name="bottling_details[${wineCounter}][packing_requirements]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="Branded Standup 12">Branded Standup 12</option>
                                            <option value="Branded Standup 6">Branded Standup 6</option>
                                            <option value="Branded Laydown 12 (2x6)">Branded Laydown 12 (2x6)</option>
                                            <option value="Branded Laydown 6 (2x3)">Branded Laydown 6 (2x3)</option>
                                            <option value="Branded Laydown 6 (1x6)">Branded Laydown 6 (1x6)</option>
                                            <option value="Plain Standup 12">Plain Standup 12</option>
                                            <option value="Plain Standup 6">Plain Standup 6</option>
                                            <option value="Plain Laydown 12 (2x6)">Plain Laydown 12 (2x6)</option>
                                            <option value="Plain Laydown 6 (2x3)">Plain Laydown 6 (2x3)</option>
                                            <option value="Plain Laydown 6 (1x6)">Plain Laydown 6 (1x6)</option>
                                            <option value="Cellar Stacks">Cellar Stacks</option>
                                            <option value="Bins">Bins</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="other-input-container col-md-4"></div>
                                </div>
                            `;
                    } else if (e.target.value === 'LabelPack') {
                        fields.innerHTML = `
                      <h5 class="section-title">Wine</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="year" class="form-label">Year  *</label>
                                        <input type="number" id="year" name="bottling_details[${wineCounter}][year]" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="brand-name" class="form-label">Brand Name  *</label>
                                        <input type="text" id="brand-name" name="bottling_details[${wineCounter}][brand_name]" class="form-control"required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="variety" class="form-label">Variety/Name  *</label>
                                        <input type="text" id="variety" name="bottling_details[${wineCounter}][variety]" class="form-control"  required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                     <div class="col-md-4">
                                        <label for="tank" class="form-label">Volume(dozens)</label>
                                        <input type="number" id="tank" name="bottling_details[${wineCounter}][volume]" class="form-control" >
                                    </div>


                                </div>

                                <h5 class="section-title">Bottle</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="bottle-type-${wineCounter}" class="form-label">Bottle Type  *</label>
                                        <select id="bottle-type-${wineCounter}" name="bottling_details[${wineCounter}][bottle_type]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="Riesling">Riesling</option>
                                            <option value="Punted Burgundy">Punted Burgundy</option>
                                            <option value="Premium Burgundy">Premium Burgundy</option>
                                            <option value="Square Heel Burgundy">Square Heel Burgundy</option>
                                            <option value="Punted Claret">Punted Claret</option>
                                            <option value="Premium Claret">Premium Claret</option>
                                            <option value="Super Premium Claret">Super Premium Claret</option>
                                            <option value="Atlas">Atlas</option>
                                            <option value="Epic">Epic</option>
                                            <option value="Odeon">Odeon</option>
                                            <option value="Classique">Classique</option>

                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="bottle-size" class="form-label">Size *</label>
                                        <select id="bottle-size-${wineCounter}" name="bottling_details[${wineCounter}][bottle_size]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="750ml">750ml</option>
                                            <option value="375ml">375ml</option>
                                            <option value="Other">Other (Please specify)</option>
                                        </select>
                                    </div>
                                     <div class="col-md-4" id="size-other-${wineCounter}" style="display:none;">
                                        <label for="color_other" class="form-label">Please Specify Bottle Size</label>
                                        <input type="number" name="bottling_details[${wineCounter}][bottle_size_other]" class="form-control">
                                    </div>
                                </div>

                                <h5 class="section-title">LABEL</h5>
                                <div class="row mb-3">
                                    <div  class="col-md-4" >
                                    <label for="labeling_type" class="form-label">Type *</label>
                                    <select name="bottling_details[${wineCounter}][labeling]" class="form-select apply-capsule-dropdown" required>
                                       <option value="">Please select</option>
                                        <option value="Wrap">Wrap</option>
                                        <option value="Front & Back - Separate reels">Front & Back - Separate reels</option>
                                        <option value="Front & Back - Same reel">Front & Back - Same reel</option>
                                        <option value="Front only">Front only</option>
                                        <option value="Back only">Back only</option>
                                        <option value="None">None</option>
                                    </select>
                                    </div>
                                    <div  class="col-md-4" >
                                    <label for="sample_bottle" class="form-label">Sample bottle available? *</label>
                                    <select name="bottling_details[${wineCounter}][sample_bottle]" class="form-select apply-capsule-dropdown" required>
                                        <option value="">Please select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    </div>
                                     <div class="col-md-4">
                                         <label for="bottling_details[${wineCounter}][label_height]" class="form-label">Label Height (in milimeters)</label>
                                        <input type="text" name="bottling_details[${wineCounter}][label_height]" class="form-control" placeholder="Bottom of bottle to bottom of label">
                                    </div>
                                </div>

                                <h5 class="section-title">Packaging</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="packing-requirements" class="form-label">Type  *</label>
                                        <select id="packing-requirements-${wineCounter}" name="bottling_details[${wineCounter}][packing_requirements]" class="form-select other-option" required>
                                            <option value="">Please select</option>
                                            <option value="Branded Standup 12">Branded Standup 12</option>
                                            <option value="Branded Standup 6">Branded Standup 6</option>
                                            <option value="Branded Laydown 12 (2x6)">Branded Laydown 12 (2x6)</option>
                                            <option value="Branded Laydown 6 (2x3)">Branded Laydown 6 (2x3)</option>
                                            <option value="Branded Laydown 6 (1x6)">Branded Laydown 6 (1x6)</option>
                                            <option value="Plain Standup 12">Plain Standup 12</option>
                                            <option value="Plain Standup 6">Plain Standup 6</option>
                                            <option value="Plain Laydown 12 (2x6)">Plain Laydown 12 (2x6)</option>
                                            <option value="Plain Laydown 6 (2x3)">Plain Laydown 6 (2x3)</option>
                                            <option value="Plain Laydown 6 (1x6)">Plain Laydown 6 (1x6)</option>
                                            <option value="Cellar Stacks">Cellar Stacks</option>
                                            <option value="Bins">Bins</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="other-input-container col-md-4"></div>
                                </div>
                        `;
                    }
                }
            });


            // Remove product
            productContainer.querySelector('.btn-close').addEventListener('click', function() {
                productList.removeChild(productContainer);

                // Recalculate wine numbers
                wineCounter = 1; // Reset the counter
                const allProducts = document.querySelectorAll('.product-item h4');
                allProducts.forEach((item) => {
                    item.textContent = `item#${wineCounter}`;
                    wineCounter++;
                });
                wineCounter = allProducts.length + 1; // Update the counter for next addition
            });
        });

        //    please specify
        document.addEventListener('DOMContentLoaded', function() {
            // Delegate the event to the document
            document.addEventListener('change', function(event) {
                // Check if the event target is a dropdown with the class 'other-option'
                if (event.target.classList.contains('other-option')) {
                    const dropdown = event.target;
                    // Get the current row, other-input-container, and dynamic row
                    const row = dropdown.closest('.row');
                    const wineIndex = dropdown.name.match(/\[(\d+)\]/)[1];
                    const otherInputContainer = row.querySelector('.other-input-container');
                    const manPrev = document.getElementById(`man-pre-${wineIndex}`);
                    const manAfter = document.getElementById(`man-aft-${wineIndex}`);
                    const otherColor = document.getElementById(`color-other-${wineIndex}`);
                    const otherSize = document.getElementById(`size-other-${wineIndex}`);
                    const applyCapsule = document.getElementById(`apply-capsule-${wineIndex}`);
                    const capsuleDesc = document.getElementById(`capsule-description-${wineIndex}`);


                    if (dropdown.id === `bottle-color-${wineIndex}`) {
                        if (dropdown.value === 'Other') {
                            otherColor.style.display = 'block';
                            manPrev.style.display = 'none';
                            manAfter.style.display = 'block';
                        } else {
                            otherColor.style.display = 'none';
                            manPrev.style.display = 'none';
                            manAfter.style.display = 'block';
                        }
                    } else if (dropdown.id === `bottle-size-${wineIndex}`) {
                        if (dropdown.value === 'Other') {
                            otherSize.style.display = 'block';
                            manPrev.style.display = 'none';
                            manAfter.style.display = 'block';
                        } else {
                            otherSize.style.display = 'none';
                            manPrev.style.display = 'none';
                            manAfter.style.display = 'block';
                        }
                    }


                    // closure
                    otherInputContainer.innerHTML = '';

                    // Handle "Other" option logic
                    if (dropdown.id === `closure-type-${wineIndex}` && dropdown.value === 'Other') {
                        applyCapsule.style.display = 'none';
                        capsuleDesc.style.display = 'none';
                        otherInputContainer.classList.remove('col-md-12');
                        otherInputContainer.classList.add('col-md-4');
                        otherInputContainer.innerHTML = `
                        <label for="${dropdown.name}_other" class="form-label">Description *</label>
                        <input type="text" name="bottling_details[${wineCounter}][closure_description]" class="form-control" placeholder="Closure Description" required>
                    `;
                    }

                    // Handle "Screwcap" options logic
                    else if (dropdown.value === '30mm Screwcap' || dropdown.value ===
                        '31mm Screwcap') {
                        applyCapsule.style.display = 'none';
                        capsuleDesc.style.display = 'none';
                        otherInputContainer.innerHTML = `
                    <label for="${dropdown.name}_screwcap_desc" class="form-label">Screwcap Description *</label>
                    <input type="text" name="bottling_details[${wineCounter}][closure_description]" class="form-control" placeholder="Colour, Branding etc" required>
                `;

                    }

                    // Handle "Cork" options logic
                    else if (
                        dropdown.value === 'Natural-Cork' ||
                        dropdown.value === 'Diam 5' ||
                        dropdown.value === 'Diam 10' ||
                        dropdown.value === 'Diam 15' ||
                        dropdown.value === 'Diam 20'
                    ) {
                        // otherInputContainer.classList.remove('col-md-12');
                        // otherInputContainer.classList.add('col-md-6');
                        applyCapsule.style.display = 'block';
                        otherInputContainer.innerHTML = `
                    <label for="${dropdown.name}_screwcap_desc" class="form-label">Cork Description *</label>
                    <input type="text" name="bottling_details[${wineCounter}][closure_description]" class="form-control" placeholder="Plain, Banded etc" required>
                `;
                        const applyCapsuleDropdown = document.querySelector('[name="bottling_details[' +
                            wineCounter + '][apply_capsule]"]');

                        applyCapsuleDropdown.addEventListener('change', (event) => {
                            if (event.target.value === 'Yes') {
                                capsuleDesc.style.display = 'block'; // Show capsule description
                            } else {
                                capsuleDesc.style.display = 'none'; // Hide capsule description
                            }
                        });
                    } else if (dropdown.value === "") {
                        applyCapsule.style.display = 'none';
                        capsuleDesc.style.display = 'none';
                    }
                    //packaging
                    if (dropdown.id === `packing-requirements-${wineIndex}` && dropdown.value === 'Other') {
                        otherInputContainer.innerHTML = `
                    <label for="${dropdown.name}_other" class="form-label">Description *</label>
                    <input type="text" name="${dropdown.name}_other" class="form-control" placeholder="Colour, Branding etc" required>
                `;
                    } else if (dropdown.id === `packing-requirements-${wineIndex}` && (dropdown.value !==
                            'Cellar Stacks' && dropdown.value !== 'Bins')) {
                        otherInputContainer.innerHTML = `
                    <label for="${dropdown.name}_other" class="form-label">Carton Message *</label>
                    <input type="text" name="bottling_details[${wineCounter}][cartoon]" class="form-control" required>
                `;
                    } else if (dropdown.value == 'Other') {
                        otherInputContainer.innerHTML = '';
                    }

                    //genarel
                    if (dropdown.value === 'Other' && dropdown.id !== `closure-type-${wineIndex}`) {
                        otherInputContainer.innerHTML = `
                <label for="${dropdown.name}_other" class="form-label">Description *</label>
                <input type="text" name="${dropdown.name}_other" class="form-control" required>
                `;
                    } else if (dropdown.value === 'Other' && dropdown.id === `closure-type-${wineIndex}`) {
                        otherInputContainer.innerHTML = `
                <label for="${dropdown.name}_other" class="form-label">Description *</label>
                <input type="text" name="${dropdown.name}_other" class="form-control" placeholder="Colour, Branding etc" required>
                `
                    }
                }
            });


            // Handle form submission
            // Handle form submission
            document.querySelector('form').addEventListener('submit', function(event) {
                let isValid = true; // Flag to track form validity

                // Validate required inputs and selects
                const formFields = document.querySelectorAll('input[required], select[required], textarea[required]');
                formFields.forEach(field => {
                    field.classList.remove('input-error'); // Remove any previous error highlighting
                    // Check if the field is empty
                    if (field.value.trim() === '') {
                        isValid = false; // Mark the form as invalid
                        field.classList.add('input-error'); // Highlight the field
                    }
                });

                // Validate dynamic "Other" inputs for dropdowns
                const dropdowns = document.querySelectorAll('.other-option');
                dropdowns.forEach(function(dropdown) {
                    const otherInput = dropdown.closest('.row').querySelector(
                        '.other-input-container input');

                    if (dropdown.value === 'Other' && otherInput) {
                        if (otherInput.value.trim() === '') {
                            isValid = false;
                            otherInput.classList.add('input-error'); // Highlight the dynamic input
                            // Add error message
                            const error = document.createElement('div');
                            error.textContent = 'Please specify the "Other" value.';
                        } else {
                            // Set dropdown value to dynamic input value
                            dropdown.value = otherInput.value;
                        }
                    }
                });

                // Prevent form submission if invalid
                if (!isValid) {
                    event.preventDefault(); // Stop form submission

                }
            });

        });
    </script>

</body>

</html>
