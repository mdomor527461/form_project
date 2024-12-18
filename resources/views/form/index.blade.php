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
        <form action="{{ route('form.store') }}" method="POST" style="background-color: white;padding:20px">
            @csrf
            <!-- Customer Information -->
            <h3>Booking Form</h3>
            <div class="section-container">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="winery" class="form-label">Winery *</label>
                        <input type="text" id="winery" name="winery" class="form-control"
                            placeholder="Enter Winery Name" required>
                        <div class="text-danger mt-1">Winery is required.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="bottling-date" class="form-label">Confirmed Bottling Date *</label>
                        <input type="date" id="bottling-date" name="bottling_date" class="form-control" required>
                        <div class="text-danger mt-1">Confirmed Bottling Date is required.</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="bottling-address" class="form-label">Bottling Address *</label>
                        <input type="text" id="bottling-address" name="bottling_address" class="form-control"
                            placeholder="Address Line 1" required>
                        <input type="text" id="city" name="city" class="form-control mt-2" placeholder="City"
                            required>
                        <input type="text" id="zip" name="zip" class="form-control mt-2"
                            placeholder="Postal / Zip Code" required>
                        <div class="text-danger mt-1">Address details are required.</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="contact-person" class="form-label">Contact Person *</label>
                        <input type="text" id="contact-person" name="contact_person" class="form-control"
                            placeholder="Full Name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="contact-phone" class="form-label">Contact Phone *</label>
                        <input type="text" id="contact-phone" name="contact_phone" class="form-control"
                            placeholder="Phone Number" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email to Send Invoice *</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Email Address" required>
                    </div>
                    <div class="col-md-6">
                        <label for="power" class="form-label">Power *</label>
                        <select id="power" name="power" class="form-select" required>
                            <option value="">Select Power Requirement</option>
                            <option value="Single Phase">5 pin, 3 phase power supply</option>
                            <option value="MWP Generator">MWP Generator required</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Bottling Details -->
            <h3 class="section-title">Bottling Details</h3>
            <div class="section-container">
                <div id="product-list"></div>
                <button type="button" class="btn btn-add btn-sm mb-3" id="add-product">+ Add Another Wine</button>
                <div class="col-md-12">
                    <label for="special-requirements" class="form-label">Special Requirements</label>
                    <textarea id="special-requirements" name="special_requirements" class="form-control" rows="3"
                        placeholder="Mention any relevant information, e.g., protocols, filtering, etc." style="height: 65px;"></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-4 d-flex justify-content-start">
                <button type="submit" class="btn btn-submit">Submit</button>
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
        let wineCounter = 1; // Initialize wine counter

        document.getElementById('add-product').addEventListener('click', function() {
            const productList = document.getElementById('product-list');

            // Add the initial product container
            const productContainer = document.createElement('div');
            productContainer.className = 'product-item mb-3 p-3 border rounded';
            productContainer.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4>item#${wineCounter}</h4> <!-- Dynamic wine title -->
                    <button type="button" class="btn-close btn-sm"></button>
                </div>
                <div>
                    <label class="form-label">Service Required *</label>
                    <div>
                        <input type="radio" name="bottling_details[${wineCounter}][service]" value="FillLabelPack" required> Fill, Label, Pack
                        <input type="radio" name="bottling_details[${wineCounter}][service]" value="FillPack" required> Fill, Pack
                        <input type="radio" name="bottling_details[${wineCounter}][service]" value="LabelPack" required> Label, Pack
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

                                <h5 class="section-title">Wine Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="brand-name" class="form-label">Brand Name *</label>
                                        <input type="text" id="brand-name" name="bottling_details[${wineCounter}][brand_name]" class="form-control" placeholder="Enter Brand Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="year" class="form-label">Year *</label>
                                        <input type="number" id="year" name="bottling_details[${wineCounter}][year]" class="form-control" placeholder="Enter Year" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="variety" class="form-label">Variety/Name *</label>
                                        <input type="text" id="variety" name="bottling_details[${wineCounter}][variety]" class="form-control" placeholder="Enter Variety/Name" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="volume" class="form-label">Volume (Litres) *</label>
                                        <input type="number" id="volume" name=" bottling_details[${wineCounter}][volume]" class="form-control" placeholder="Enter Volume" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tank" class="form-label">Tank/Vessel Number</label>
                                        <input type="text" id="tank" name="bottling_details[${wineCounter}][tank]" class="form-control" placeholder="Enter Tank/Vessel Number">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pre-bottling-filtration" class="form-label">Pre Bottling Filtration *</label>
                                        <select id="pre-bottling-filtration" name=" bottling_details[${wineCounter}][pre_bottling_filtration]" class="form-select" required>
                                            <option value="CrossFlow">CrossFlow</option>
                                            <option value="Rack">Rack</option>
                                            <option value="None">None</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="filtration-bottling" class="form-label">Filtration Required at Bottling *</label>
                                        <select id="filtration-bottling" name="bottling_details[${wineCounter}][filtration_bottling]"  class="form-select" required>
                                            <option value="Sterile">Sterile -.45 um</option>
                                            <option value="Lenticular">Ek Lenticular -.5 nominal</option>
                                            <option value="Lenticular300">300 Lenticular  ?? um nominal</option>
                                            <option value="None">None</option>

                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Gas Protection Required?</label>
                                        <div>
                                            <input type="radio" name="bottling_details[${wineCounter}][gas_protection]" value="Yes" required> Yes
                                            <input type="radio" name="bottling_details[${wineCounter}][gas_protection]" value="No" required> No
                                        </div>
                                        <small class="form-text text-muted">LN2 Bottle sparging and headspace protection</small>
                                    </div>
                                </div>

                                <!-- Title: Bottle Details -->
                                <h5 class="section-title">Bottle Details</h5>
                                <div class="row mb-3">
                                   <div>
                                        <label for="bottle-type" class="form-label">Bottle Type *</label>
                                        <select id="bottle-type" name="bottling_details[${wineCounter}][bottle_type]" class="form-select other-option" required>
                                            <option value="">Select Bottle Type</option>
                                            <option value="Riesling">Riesling</option>
                                            <option value="Punted Burgundy">Punted Burgundy</option>
                                            <option value="Premium Burgundy">Premium Burgundy</option>
                                            <option value="Other">Other (Please specify)</option>
                                        </select>
                                        <!-- Container for dynamic input -->
                                        <div class="other-input-container mt-2"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="manufacturer-code" class="form-label">Manufacturer & Item Code</label>
                                        <input type="text" id="manufacturer-code" name="bottling_details[${wineCounter}][manufacturer_code]" class="form-control" placeholder="Enter Manufacturer Code">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bottle-color" class="form-label">Bottle Colour</label>
                                        <select id="bottle-color" name="bottling_details[${wineCounter}][bottle_color]" class="form-select other-option">
                                            <option value="">Select Bottle Colour</option>
                                            <option value="Flint">Flint</option>
                                            <option value="Antique Green">Antique Green</option>
                                            <option value="French Green">French Green</option>
                                            <option value="Amber">Amber</option>
                                            <option value="Arctic Blue">Arctic Blue</option>
                                            <option value="Other">Other (Please specify)</option>
                                        </select>
                                        <!-- Container for dynamic input -->
                                        <div class="other-input-container mt-2"></div>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="bottle-size" class="form-label">Bottle Size *</label>
                                        <select id="bottle-size" name="bottling_details[${wineCounter}][bottle_size]" class="form-select other-option" required>
                                            <option value="">Select Bottle Size</option>
                                            <option value="750ml">750ml</option>
                                            <option value="375ml">375ml</option>
                                            <option value="Other">ohter(please specify)</option>
                                        </select>
                                        <div class="other-input-container mt-2"></div>
                                    </div>
                                </div>

                                <!-- Title: Closure Details -->
                                <h5 class="section-title">Closure Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                       <label for="closure-type" class="form-label">Closure Type *</label>
                                        <select id="closure-type" name="bottling_details[${wineCounter}][closure_type]" class="form-select" required>
                                            <option value="">Select Closure Type</option>
                                            <option value="Screwcap-30x60mm">Screwcap - 30x60mm</option>
                                            <option value="Screwcap-31x60mm">Screwcap - 31x60mm</option>
                                            <option value="Cork-Natural">Cork - Natural</option>
                                            <option value="Cork-Diam5">Cork - Diam 5</option>
                                            <option value="Cork-Diam10">Cork - Diam 10</option>
                                            <option value="Cork-Diam20">Cork - Diam 20</option>
                                            <option value="Cork-Diam30">Cork - Diam 30</option>
                                            <option value="Other">Other</option>
                                        </select>

                                    </div>
                                </div>

                                <!-- Title: Labelling Details -->
                                <h5 class="section-title">Labelling Details</h5>
                                <div class="row mb-3">
                                   <label for="labelling" class="form-label">Labelling *</label>
                                    <select id="labelling" name="bottling_details[${wineCounter}][labelling]" class="form-select" required>
                                        <option value="">Select Labelling Option</option>
                                        <option value="Front and Back - separate reels">Front and Back - separate reels</option>
                                        <option value="Front and Back - same reel">Front and Back - same reel</option>
                                        <option value="Front Only">Front Only</option>
                                        <option value="Back Only">Back Only</option>
                                    </select>

                                    <div class="col-md-6">
                                        <label for="label-height" class="form-label">Label Height</label>
                                        <input type="number" id="label-height" name="bottling_details[${wineCounter}][label_height]" class="form-control" placeholder="From bottom of label to bottom of bottle">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Will a Sample Bottle be Available?</label>
                                        <div>
                                            <input type="radio" name="bottling_details[${wineCounter}][sample_bottle]" value="0" required> Yes
                                            <input type="radio" name="bottling_details[${wineCounter}][sample_bottle]" value="1" required> No
                                        </div>
                                    </div>
                                </div>

                                <!-- Title: Packaging Details -->
                                <h5 class="section-title">Packaging Details</h5>
                                <div class="row mb-3">
                                    <label for="packing-requirements" class="form-label">Packing Requirements *</label>
                                    <select id="packing-requirements" name="bottling_details[${wineCounter}][packing_requirements]" class="form-select" required>
                                        <option value="">Select Packing Requirement</option>
                                        <option value="Branded Standup 12">Branded Standup 12</option>
                                        <option value="Branded Standup 6">Branded Standup 6</option>
                                        <option value="Branded Laydown 12 (2x6)">Branded Laydown 12 (2x6)</option>
                                        <option value="Branded Laydown 6 (2x3)">Branded Laydown 6 (2x3)</option>
                                        <option value="Branded Laydown 6 (1x6)">Branded Laydown 6 (1x6)</option>
                                        <option value="Plain Standup 12">Plain Standup 12</option>
                                        <option value="Plain Standup 6">Plain Standup 6</option>
                                        <option value="Plain Laydown 12 (2x6)">Plain Laydown 12 (2x6)</option>
                                        <option value="Plain Laydown 6 (2x3)">Plain Laydown 6 (2x3)</option>
                                    </select>

                                    <div class="col-md-6">
                                        <label for="cartoon"  class="form-label">Print required on cartoon *</label>
                                        <input type="text" name="bottling_details[${wineCounter}][cartoon]" id="packing-requirements" class="form-control" placeholder="Enter Packing Requirements" required>
                                    </div>
                                </div>
                            `;
                    } else if (e.target.value === 'FillPack') {
                        fields.innerHTML = `
                                     <h5 class="section-title">Wine Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="brand-name" class="form-label">Brand Name *</label>
                                        <input type="text" id="brand-name" name="bottling_details[${wineCounter}][brand_name]" class="form-control" placeholder="Enter Brand Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="year" class="form-label">Year *</label>
                                        <input type="number" id="year" name="bottling_details[${wineCounter}][year]" class="form-control" placeholder="Enter Year" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="variety" class="form-label">Variety/Name *</label>
                                        <input type="text" id="variety" name="bottling_details[${wineCounter}][variety]" class="form-control" placeholder="Enter Variety/Name" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="volume" class="form-label">Volume (Litres) *</label>
                                        <input type="number" id="volume" name=" bottling_details[${wineCounter}][volume]" class="form-control" placeholder="Enter Volume" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tank" class="form-label">Tank/Vessel Number</label>
                                        <input type="text" id="tank" name="bottling_details[${wineCounter}][tank]" class="form-control" placeholder="Enter Tank/Vessel Number">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pre-bottling-filtration" class="form-label">Pre Bottling Filtration *</label>
                                        <select id="pre-bottling-filtration" name=" bottling_details[${wineCounter}][pre_bottling_filtration]" class="form-select" required>
                                            <option value="CrossFlow">CrossFlow</option>
                                            <option value="Rack">Rack</option>
                                            <option value="None">None</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="filtration-bottling" class="form-label">Filtration Required at Bottling *</label>
                                        <select id="filtration-bottling" name="bottling_details[${wineCounter}][filtration_bottling]"  class="form-select" required>
                                            <option value="Sterile">Sterile -.45 um</option>
                                            <option value="Lenticular">Ek Lenticular -.5 nominal</option>
                                            <option value="Lenticular300">300 Lenticular  ?? um nominal</option>
                                            <option value="None">None</option>

                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Gas Protection Required?</label>
                                        <div>
                                            <input type="radio" name="bottling_details[${wineCounter}][gas_protection]" value="Yes" required> Yes
                                            <input type="radio" name="bottling_details[${wineCounter}][gas_protection]" value="No" required> No
                                        </div>
                                        <small class="form-text text-muted">LN2 Bottle sparging and headspace protection</small>
                                    </div>
                                </div>

                                <!-- Title: Bottle Details -->
                                <h5 class="section-title">Bottle Details</h5>
                                <div class="row mb-3">
                                   <div>
                                        <label for="bottle-type" class="form-label">Bottle Type *</label>
                                        <select id="bottle-type" name="bottling_details[${wineCounter}][bottle_type]" class="form-select other-option" required>
                                            <option value="">Select Bottle Type</option>
                                            <option value="Riesling">Riesling</option>
                                            <option value="Punted Burgundy">Punted Burgundy</option>
                                            <option value="Premium Burgundy">Premium Burgundy</option>
                                            <option value="Other">Other (Please specify)</option>
                                        </select>
                                        <!-- Container for dynamic input -->
                                        <div class="other-input-container mt-2"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="manufacturer-code" class="form-label">Manufacturer & Item Code</label>
                                        <input type="text" id="manufacturer-code" name="bottling_details[${wineCounter}][manufacturer_code]" class="form-control" placeholder="Enter Manufacturer Code">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bottle-color" class="form-label">Bottle Colour</label>
                                        <select id="bottle-color" name="bottling_details[${wineCounter}][bottle_color]" class="form-select other-option">
                                            <option value="">Select Bottle Colour</option>
                                            <option value="Flint">Flint</option>
                                            <option value="Antique Green">Antique Green</option>
                                            <option value="French Green">French Green</option>
                                            <option value="Amber">Amber</option>
                                            <option value="Arctic Blue">Arctic Blue</option>
                                            <option value="Other">Other (Please specify)</option>
                                        </select>
                                        <!-- Container for dynamic input -->
                                        <div class="other-input-container mt-2"></div>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="bottle-size" class="form-label">Bottle Size *</label>
                                        <select id="bottle-size" name="bottling_details[${wineCounter}][bottle_size]" class="form-select other-option" required>
                                            <option value="">Select Bottle Size</option>
                                            <option value="750ml">750ml</option>
                                            <option value="375ml">375ml</option>
                                            <option value="Other">ohter(please specify)</option>
                                        </select>
                                        <div class="other-input-container mt-2"></div>
                                    </div>
                                </div>

                                <!-- Title: Closure Details -->
                                <h5 class="section-title">Closure Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                       <label for="closure-type" class="form-label">Closure Type *</label>
                                        <select id="closure-type" name="bottling_details[${wineCounter}][closure_type]" class="form-select" required>
                                            <option value="">Select Closure Type</option>
                                            <option value="Screwcap-30x60mm">Screwcap - 30x60mm</option>
                                            <option value="Screwcap-31x60mm">Screwcap - 31x60mm</option>
                                            <option value="Cork-Natural">Cork - Natural</option>
                                            <option value="Cork-Diam5">Cork - Diam 5</option>
                                            <option value="Cork-Diam10">Cork - Diam 10</option>
                                            <option value="Cork-Diam20">Cork - Diam 20</option>
                                            <option value="Cork-Diam30">Cork - Diam 30</option>
                                            <option value="Other">Other</option>
                                        </select>

                                    </div>
                                </div>

                                <!-- Title: Labelling Details -->

                                <!-- Title: Packaging Details -->
                                <h5 class="section-title">Packaging Details</h5>
                                <div class="row mb-3">
                                    <label for="packing-requirements" class="form-label">Packing Requirements *</label>
                                    <select id="packing-requirements" name="bottling_details[${wineCounter}][packing_requirements]" class="form-select" required>
                                        <option value="">Select Packing Requirement</option>
                                        <option value="Branded Standup 12">Branded Standup 12</option>
                                        <option value="Branded Standup 6">Branded Standup 6</option>
                                        <option value="Branded Laydown 12 (2x6)">Branded Laydown 12 (2x6)</option>
                                        <option value="Branded Laydown 6 (2x3)">Branded Laydown 6 (2x3)</option>
                                        <option value="Branded Laydown 6 (1x6)">Branded Laydown 6 (1x6)</option>
                                        <option value="Plain Standup 12">Plain Standup 12</option>
                                        <option value="Plain Standup 6">Plain Standup 6</option>
                                        <option value="Plain Laydown 12 (2x6)">Plain Laydown 12 (2x6)</option>
                                        <option value="Plain Laydown 6 (2x3)">Plain Laydown 6 (2x3)</option>
                                    </select>

                                    <div class="col-md-6">
                                        <label for="cartoon"  class="form-label">Print required on cartoon *</label>
                                        <input type="text" name="bottling_details[${wineCounter}][cartoon]" id="packing-requirements" class="form-control" placeholder="Enter Packing Requirements" required>
                                    </div>
                                </div>
                        `;
                    } else if (e.target.value === 'LabelPack') {
                        fields.innerHTML = `
                              <h5 class="section-title">Wine Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="brand-name" class="form-label">Brand Name *</label>
                                        <input type="text" id="brand-name" name="bottling_details[${wineCounter}][brand_name]" class="form-control" placeholder="Enter Brand Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="year" class="form-label">Year *</label>
                                        <input type="number" id="year" name="bottling_details[${wineCounter}][year]" class="form-control" placeholder="Enter Year" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="variety" class="form-label">Variety/Name *</label>
                                        <input type="text" id="variety" name="bottling_details[${wineCounter}][variety]" class="form-control" placeholder="Enter Variety/Name" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="volume" class="form-label">Volume (Dozens) *</label>
                                        <input type="number" id="volume" name=" bottling_details[${wineCounter}][volume]" class="form-control" placeholder="Enter Volume" required>
                                    </div>
                                </div>

                                <!-- Title: Bottle Details -->
                                <h5 class="section-title">Bottle Details</h5>
                                <div class="row mb-3">
                                     <div>
                                        <label for="bottle-type" class="form-label">Bottle Type *</label>
                                        <select id="bottle-type" name="bottling_details[${wineCounter}][bottle_type]" class="form-select other-option" required>
                                            <option value="">Select Bottle Type</option>
                                            <option value="Riesling">Riesling</option>
                                            <option value="Punted Burgundy">Punted Burgundy</option>
                                            <option value="Premium Burgundy">Premium Burgundy</option>
                                            <option value="Other">Other (Please specify)</option>
                                        </select>
                                        <!-- Container for dynamic input -->
                                        <div class="other-input-container mt-2"></div>
                                    </div>
                                     <div class="col-md-6">
                                        <label for="bottle-size" class="form-label">Bottle Size *</label>
                                        <select id="bottle-size" name="bottling_details[${wineCounter}][bottle_size]" class="form-select other-option" required>
                                            <option value="">Select Bottle Size</option>
                                            <option value="750ml">750ml</option>
                                            <option value="375ml">375ml</option>
                                            <option value="Other">ohter(please specify)</option>
                                        </select>
                                        <div class="other-input-container mt-2"></div>
                                    </div>
                                </div>

                                <!-- Title: Labelling Details -->
                                <h5 class="section-title">Labelling Details</h5>
                                <div class="row mb-3">
                                   <label for="labelling" class="form-label">Labelling *</label>
                                    <select id="labelling" name="bottling_details[${wineCounter}][labelling]" class="form-select" required>
                                        <option value="">Select Labelling Option</option>
                                        <option value="Front and Back - separate reels">Front and Back - separate reels</option>
                                        <option value="Front and Back - same reel">Front and Back - same reel</option>
                                        <option value="Front Only">Front Only</option>
                                        <option value="Back Only">Back Only</option>
                                    </select>

                                    <div class="col-md-6">
                                        <label for="label-height" class="form-label">Label Height</label>
                                        <input type="number" id="label-height" name="bottling_details[${wineCounter}][label_height]" class="form-control" placeholder="From bottom of label to bottom of bottle">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Will a Sample Bottle be Available?</label>
                                        <div>
                                            <input type="radio" name="bottling_details[${wineCounter}][sample_bottle]" value="0" required> Yes
                                            <input type="radio" name="bottling_details[${wineCounter}][sample_bottle]" value="1" required> No
                                        </div>
                                    </div>
                                </div>

                                <!-- Title: Packaging Details -->
                                <h5 class="section-title">Packaging Details</h5>
                                <div class="row mb-3">
                                    <label for="packing-requirements" class="form-label">Packing Requirements *</label>
                                    <select id="packing-requirements" name="bottling_details[${wineCounter}][packing_requirements]" class="form-select" required>
                                        <option value="">Select Packing Requirement</option>
                                        <option value="Branded Standup 12">Branded Standup 12</option>
                                        <option value="Branded Standup 6">Branded Standup 6</option>
                                        <option value="Branded Laydown 12 (2x6)">Branded Laydown 12 (2x6)</option>
                                        <option value="Branded Laydown 6 (2x3)">Branded Laydown 6 (2x3)</option>
                                        <option value="Branded Laydown 6 (1x6)">Branded Laydown 6 (1x6)</option>
                                        <option value="Plain Standup 12">Plain Standup 12</option>
                                        <option value="Plain Standup 6">Plain Standup 6</option>
                                        <option value="Plain Laydown 12 (2x6)">Plain Laydown 12 (2x6)</option>
                                        <option value="Plain Laydown 6 (2x3)">Plain Laydown 6 (2x3)</option>
                                    </select>

                                    <div class="col-md-6">
                                        <label for="cartoon"  class="form-label">Print required on cartoon *</label>
                                        <input type="text" name="bottling_details[${wineCounter}][cartoon]" id="packing-requirements" class="form-control" placeholder="Enter Packing Requirements" required>
                                    </div>
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
            // Delegating to the parent container or the document
            document.addEventListener('change', function(event) {
                // Check if the event target is a dropdown with the class 'other-option'
                if (event.target.classList.contains('other-option')) {
                    const dropdown = event.target;

                    // Look for .other-input-container in the same parent container
                    let otherInputContainer = dropdown.parentNode.querySelector('.other-input-container');

                    // If the container doesn't exist, create it dynamically
                    if (!otherInputContainer) {
                        otherInputContainer = document.createElement('div');
                        otherInputContainer.className = 'other-input-container mt-2';
                        dropdown.parentNode.appendChild(otherInputContainer);
                    }

                    // Clear any existing dynamic input field
                    otherInputContainer.innerHTML = '';

                    // If "Other" is selected, add a text input field
                    if (dropdown.value === 'Other') {
                        const inputField = document.createElement('input');
                        inputField.type = 'text';
                        inputField.name = `${dropdown.id}_other`; // Unique name for the input
                        inputField.placeholder = 'Please specify';
                        inputField.className = 'form-control mt-2';
                        inputField.required = true; // Make it required
                        otherInputContainer.appendChild(inputField);
                    }
                }
            });
        });
    </script>

</body>

</html>
