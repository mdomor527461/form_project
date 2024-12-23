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
                    <div class="col-md-4">
                        <label for="winery" class="form-label">Winery *</label>
                        <input type="text" id="winery" name="winery" class="form-control"
                            placeholder="Enter Winery Name" required>
                        <div class="text-danger mt-1">Winery is required.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="bottling-date" class="form-label">Confirmed Bottling Date *</label>
                        <input type="date" id="bottling-date" name="bottling_date" class="form-control" required>
                        <div class="text-danger mt-1">Confirmed Bottling Date is required.</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="bottling-address" class="form-label">Bottling Address *</label>
                        <input type="text" id="bottling-address" name="bottling_address" class="form-control"
                            placeholder="Address Line 1" required>
                        <div class="text-danger mt-1">Address details are required.</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="city" name="city" class="form-control mt-2" placeholder="City"
                            required>
                        <div class="text-danger mt-1">Address details are required.</div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="zip" name="zip" class="form-control mt-2"
                            placeholder="Postal / Zip Code" required>
                        <div class="text-danger mt-1">Address details are required.</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="contact-person" class="form-label">Contact Person *</label>
                        <input type="text" id="contact-person" name="contact_person" class="form-control"
                            placeholder="Full Name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="contact-phone" class="form-label">Contact Phone *</label>
                        <input type="text" id="contact-phone" name="contact_phone" class="form-control"
                            placeholder="Phone Number" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email to Send Invoice *</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Email Address" required>
                    </div>
                    <div class="col-md-4">
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
                <div class="col-md-8">
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
                <div class="row">
                    <div class="col-md-8 d-flex justify-content-between align-items-center mb-2">
                    <h4>item#${wineCounter}</h4> <!-- Dynamic wine title -->
                    <button type="button" class="btn-close btn-sm"></button>
                </div>
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
                                    <div class="col-md-4">
                                        <label for="brand-name" class="form-label">Brand Name *</label>
                                        <input type="text" id="brand-name" name="bottling_details[${wineCounter}][brand_name]" class="form-control" placeholder="Enter Brand Name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="year" class="form-label">Year *</label>
                                        <input type="number" id="year" name="bottling_details[${wineCounter}][year]" class="form-control" placeholder="Enter Year" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="variety" class="form-label">Variety/Name *</label>
                                        <input type="text" id="variety" name="bottling_details[${wineCounter}][variety]" class="form-control" placeholder="Enter Variety/Name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="volume" class="form-label">Volume (Litres) *</label>
                                        <input type="number" id="volume" name=" bottling_details[${wineCounter}][volume]" class="form-control" placeholder="Enter Volume" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="tank" class="form-label">Tank/Vessel Number</label>
                                        <input type="text" id="tank" name="bottling_details[${wineCounter}][tank]" class="form-control" placeholder="Enter Tank/Vessel Number">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pre-bottling-filtration" class="form-label">Pre Bottling Filtration *</label>
                                        <select id="pre-bottling-filtration" name=" bottling_details[${wineCounter}][pre_bottling_filtration]" class="form-select" required>
                                            <option value="CrossFlow">CrossFlow</option>
                                            <option value="Racked">Racked</option>
                                            <option value="None">None</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="filtration-bottling" class="form-label">Filtration Required at Bottling *</label>
                                        <select id="filtration-bottling" name="bottling_details[${wineCounter}][filtration_bottling]" class="form-select" required>
                                            <option value="Sterile">Sterile -.45 um</option>
                                            <option value="Lenticular">Ek Lenticular -.5 nominal</option>
                                            <option value="Lenticular300">300 Lenticular  ?? um nominal</option>
                                            <option value="None">None</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Gas Protection Required?</label>
                                        <div>
                                            <input type="radio" name="bottling_details[${wineCounter}][gas_protection]" value="Yes" required> Yes
                                            <input type="radio" name="bottling_details[${wineCounter}][gas_protection]" value="No" required> No
                                        </div>
                                        <small class="form-text text-muted">LN2 Bottle sparging and headspace protection</small>
                                    </div>
                                </div>

                                <h5 class="section-title">Bottle Details</h5>
                               <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="bottle-type" class="form-label">Bottle Type *</label>
                                    <select id="bottle-type" name="bottling_details[${wineCounter}][bottle_type]" class="form-select other-option" required>
                                        <option value="">Select Bottle Type</option>
                                        <option value="Riesling">Riesling</option>
                                        <option value="Punted Burgundy">Punted Burgundy</option>
                                        <option value="Premium Burgundy">Premium Burgundy</option>
                                        <option value="Punted Claret">Punted Claret</option>
                                        <option value="Premium Claret">Premium Claret</option>
                                        <option value="Super Premium Claret">Super Premium Claret</option>
                                        <option value="Atlas">Atlas</option>
                                        <option value="Other">Other (Please specify)</option>
                                    </select>
                                </div>
                                <div class="col-md-4 manufacturer-container">
                                    <label for="manufacturer-code" class="form-label">Manufacturer & Item Code</label>
                                    <input type="text" id="manufacturer-code" name="bottling_details[${wineCounter}][manufacturer_code]" class="form-control" placeholder="Enter Manufacturer Code">
                                </div>
                                <div class="col-md-4 other-input-container"></div>
                            </div>
                            <div class="row mb-3 dynamic-row" style="display: none;">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 manufacturer-container"></div>
                            </div>


                                <div class="row mb-3">
                                    <div class="col-md-4">
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

                                    </div>
                                    <div class="other-input-container col-md-4"></div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="bottle-size" class="form-label">Bottle Size *</label>
                                        <select id="bottle-size" name="bottling_details[${wineCounter}][bottle_size]" class="form-select other-option" required>
                                            <option value="">Select Bottle Size</option>
                                            <option value="750ml">750ml</option>
                                            <option value="375ml">375ml</option>
                                            <option value="Other">Other (Please specify)</option>
                                        </select>

                                    </div>
                                    <div class="other-input-container col-md-4"></div>
                                </div>

                                <h5 class="section-title">Closure Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="closure-type" class="form-label">Closure Type *</label>
                                        <select id="closure-type" name="bottling_details[${wineCounter}][closure_type]" class="form-select other-option" required>
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
                                    <div class="other-input-container col-md-4"></div>
                                </div>

                                <h5 class="section-title">Labelling Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="labelling" class="form-label">Labelling *</label>
                                        <select id="labelling" name="bottling_details[${wineCounter}][labelling]" class="form-select" required>
                                            <option value="">Select Labelling Option</option>
                                            <option value="Front and Back - separate reels">Front and Back - separate reels</option>
                                            <option value="Front and Back - same reel">Front and Back - same reel</option>
                                            <option value="Front Only">Front Only</option>
                                            <option value="Back Only">Back Only</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="label-height" class="form-label">Label Height</label>
                                        <input type="number" id="label-height" name="bottling_details[${wineCounter}][label_height]" class="form-control" placeholder="From bottom of label to bottom of bottle">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Will a Sample Bottle be Available?</label>
                                        <div>
                                            <input type="radio" name="bottling_details[${wineCounter}][sample_bottle]" value="0" required> Yes
                                            <input type="radio" name="bottling_details[${wineCounter}][sample_bottle]" value="1" required> No
                                        </div>
                                    </div>
                                </div>

                                <h5 class="section-title">Packaging Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
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
                                            <option value="Plain Laydown 6 (1x6)">Plain Laydown 6 (1x6)</option>
                                            <option value="Cellar Stacks">Cellar Stacks</option>
                                            <option value="Bins">Bins</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="cartoon" class="form-label">Print required on carton *</label>
                                        <input type="text" name="bottling_details[${wineCounter}][cartoon]" id="packing-requirements" class="form-control" placeholder="Enter Packing Requirements" required>
                                    </div>
                                </div>

                            `;
                    } else if (e.target.value === 'FillPack') {
                        fields.innerHTML = `
                               <h5 class="section-title">Wine Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="brand-name" class="form-label">Brand Name *</label>
                                        <input type="text" id="brand-name" name="bottling_details[${wineCounter}][brand_name]" class="form-control" placeholder="Enter Brand Name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="year" class="form-label">Year *</label>
                                        <input type="number" id="year" name="bottling_details[${wineCounter}][year]" class="form-control" placeholder="Enter Year" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="variety" class="form-label">Variety/Name *</label>
                                        <input type="text" id="variety" name="bottling_details[${wineCounter}][variety]" class="form-control" placeholder="Enter Variety/Name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="volume" class="form-label">Volume (Litres) *</label>
                                        <input type="number" id="volume" name=" bottling_details[${wineCounter}][volume]" class="form-control" placeholder="Enter Volume" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="tank" class="form-label">Tank/Vessel Number</label>
                                        <input type="text" id="tank" name="bottling_details[${wineCounter}][tank]" class="form-control" placeholder="Enter Tank/Vessel Number">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pre-bottling-filtration" class="form-label">Pre Bottling Filtration *</label>
                                        <select id="pre-bottling-filtration" name=" bottling_details[${wineCounter}][pre_bottling_filtration]" class="form-select" required>
                                            <option value="CrossFlow">CrossFlow</option>
                                            <option value="Racked">Racked</option>
                                            <option value="None">None</option>
                                        </select>
                                    </div>
                                </div>
                                 <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="filtration-bottling" class="form-label">Filtration Required at Bottling *</label>
                                        <select id="filtration-bottling" name="bottling_details[${wineCounter}][filtration_bottling]" class="form-select" required>
                                            <option value="Sterile">Sterile -.45 um</option>
                                            <option value="Lenticular">Ek Lenticular -.5 nominal</option>
                                            <option value="Lenticular300">300 Lenticular  ?? um nominal</option>
                                            <option value="None">None</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Gas Protection Required?</label>
                                        <div>
                                            <input type="radio" name="bottling_details[${wineCounter}][gas_protection]" value="Yes" required> Yes
                                            <input type="radio" name="bottling_details[${wineCounter}][gas_protection]" value="No" required> No
                                        </div>
                                        <small class="form-text text-muted">LN2 Bottle sparging and headspace protection</small>
                                    </div>
                                </div>

                               <h5 class="section-title">Bottle Details</h5>
                                <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="bottle-type" class="form-label">Bottle Type *</label>
                                    <select id="bottle-type" name="bottling_details[${wineCounter}][bottle_type]" class="form-select other-option" required>
                                        <option value="">Select Bottle Type</option>
                                        <option value="Riesling">Riesling</option>
                                        <option value="Punted Burgundy">Punted Burgundy</option>
                                        <option value="Premium Burgundy">Premium Burgundy</option>
                                        <option value="Punted Claret">Punted Claret</option>
                                        <option value="Premium Claret">Premium Claret</option>
                                        <option value="Super Premium Claret">Super Premium Claret</option>
                                        <option value="Atlas">Atlas</option>
                                        <option value="Other">Other (Please specify)</option>
                                    </select>
                                </div>
                                <div class="col-md-4 manufacturer-container">
                                    <label for="manufacturer-code" class="form-label">Manufacturer & Item Code</label>
                                    <input type="text" id="manufacturer-code" name="bottling_details[${wineCounter}][manufacturer_code]" class="form-control" placeholder="Enter Manufacturer Code">
                                </div>
                                <div class="col-md-4 other-input-container"></div>
                            </div>
                            <div class="row mb-3 dynamic-row" style="display: none;">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 manufacturer-container"></div>
                            </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
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

                                    </div>
                                    <div class="other-input-container col-md-4"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="bottle-size" class="form-label">Bottle Size *</label>
                                        <select id="bottle-size" name="bottling_details[${wineCounter}][bottle_size]" class="form-select other-option" required>
                                            <option value="">Select Bottle Size</option>
                                            <option value="750ml">750ml</option>
                                            <option value="375ml">375ml</option>
                                            <option value="Other">Other (Please specify)</option>
                                        </select>

                                    </div>
                                    <div class="other-input-container col-md-4"></div>
                                </div>

                                <h5 class="section-title">Closure Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="closure-type" class="form-label">Closure Type *</label>
                                        <select id="closure-type" name="bottling_details[${wineCounter}][closure_type]" class="form-select other-option" required>
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
                                    <div class="other-input-container col-md-4"></div>
                                </div>
                                <h5 class="section-title">Packaging Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
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
                                            <option value="Plain Laydown 6 (1x6)">Plain Laydown 6 (1x6)</option>
                                            <option value="Cellar Stacks">Cellar Stacks</option>
                                            <option value="Bins">Bins</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="cartoon" class="form-label">Print required on cartoon *</label>
                                        <input type="text" name="bottling_details[${wineCounter}][cartoon]" id="packing-requirements" class="form-control" placeholder="Enter Packing Requirements" required>
                                    </div>
                                </div>

                        `;
                    } else if (e.target.value === 'LabelPack') {
                        fields.innerHTML = `
                           <h5 class="section-title">Wine Details</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="brand-name" class="form-label">Brand Name *</label>
                                <input type="text" id="brand-name" name="bottling_details[${wineCounter}][brand_name]" class="form-control" placeholder="Enter Brand Name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="year" class="form-label">Year *</label>
                                <input type="number" id="year" name="bottling_details[${wineCounter}][year]" class="form-control" placeholder="Enter Year" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="variety" class="form-label">Variety/Name *</label>
                                <input type="text" id="variety" name="bottling_details[${wineCounter}][variety]" class="form-control" placeholder="Enter Variety/Name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="volume" class="form-label">Volume (Dozens) *</label>
                                <input type="number" id="volume" name=" bottling_details[${wineCounter}][volume]" class="form-control" placeholder="Enter Volume" required>
                            </div>
                        </div>

                        <h5 class="section-title">Bottle Details</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="bottle-type" class="form-label">Bottle Type *</label>
                                <select id="bottle-type" name="bottling_details[${wineCounter}][bottle_type]" class="form-select other-option" required>
                                    <option value="">Select Bottle Type</option>
                                    <option value="Riesling">Riesling</option>
                                    <option value="Punted Burgundy">Punted Burgundy</option>
                                    <option value="Premium Burgundy">Premium Burgundy</option>
                                    <option value="Punted Claret">Punted Claret</option>
                                    <option value="Premium Claret">Premium Claret</option>
                                    <option value="Super Premium Claret">Super Premium Claret</option>
                                    <option value="Atlas">Atlas</option>
                                    <option value="Other">Other (Please specify)</option>
                                </select>
                                </div>
                                <div class="other-input-container col-md-4"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="bottle-size" class="form-label">Bottle Size *</label>
                                <select id="bottle-size" name="bottling_details[${wineCounter}][bottle_size]" class="form-select other-option" required>
                                    <option value="">Select Bottle Size</option>
                                    <option value="750ml">750ml</option>
                                    <option value="375ml">375ml</option>
                                    <option value="Other">Other (please specify)</option>
                                </select>
                                </div>
                                <div class="other-input-container col-md-4"></div>
                        </div>

                        <h5 class="section-title">Labelling Details</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="labelling" class="form-label">Labelling *</label>
                                <select id="labelling" name="bottling_details[${wineCounter}][labelling]" class="form-select" required>
                                    <option value="">Select Labelling Option</option>
                                    <option value="Front and Back - separate reels">Front and Back - separate reels</option>
                                    <option value="Front and Back - same reel">Front and Back - same reel</option>
                                    <option value="Front Only">Front Only</option>
                                    <option value="Back Only">Back Only</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="label-height" class="form-label">Label Height</label>
                                <input type="number" id="label-height" name="bottling_details[${wineCounter}][label_height]" class="form-control" placeholder="From bottom of label to bottom of bottle">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Will a Sample Bottle be Available?</label>
                                <div>
                                    <input type="radio" name="bottling_details[${wineCounter}][sample_bottle]" value="0" required> Yes
                                    <input type="radio" name="bottling_details[${wineCounter}][sample_bottle]" value="1" required> No
                                </div>
                            </div>
                        </div>

                        <h5 class="section-title">Packaging Details</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
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
                                    <option value="Plain Laydown 6 (1x6)">Plain Laydown 6 (1x6)</option>
                                    <option value="Cellar Stacks">Cellar Stacks</option>
                                    <option value="Bins">Bins</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="cartoon" class="form-label">Print required on cartoon *</label>
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
            // Delegate the event to the document
            document.addEventListener('change', function(event) {
                // Check if the event target is a dropdown with the class 'other-option'
                if (event.target.classList.contains('other-option')) {
                    const dropdown = event.target;

                    // Get the current row, manufacturer field, and dynamic row
                    const row = dropdown.closest('.row');
                    const manufacturerField = row.querySelector('.manufacturer-container');
                    const dynamicRow = row.nextElementSibling;

                    // Ensure the dynamic row exists
                    if (!dynamicRow || !dynamicRow.classList.contains('dynamic-row')) {
                        const newRow = document.createElement('div');
                        newRow.className = 'row mb-3 dynamic-row';
                        newRow.style.display = 'none';
                        row.parentNode.insertBefore(newRow, row.nextSibling);
                    }

                    // Reference the dynamic row
                    const nextRow = row.nextElementSibling;

                    // If "Other" is selected
                    if (dropdown.value === 'Other') {
                        // Clear the manufacturer field and replace with dynamic input field
                        manufacturerField.innerHTML = `
                    <label for="${dropdown.name}_other" class="form-label">Bottle Type (Other)</label>
                    <input type="text" name="${dropdown.name}_other" class="form-control" placeholder="Please specify" required>
                `;

                        // Move the original manufacturer field to the next row
                        nextRow.innerHTML = `
                    <div class="col-md-4">
                        <label for="manufacturer-code" class="form-label">Manufacturer & Item Code</label>
                        <input type="text" id="manufacturer-code" name="bottling_details[${dropdown.name}][manufacturer_code]" class="form-control" placeholder="Enter Manufacturer Code">
                    </div>
                `;
                        nextRow.style.display = 'flex'; // Show the next row

                        // Hide the original dropdown value during submission
                        dropdown.setAttribute('data-ignore', 'true');
                    } else {
                        // Reset to the original state
                        manufacturerField.innerHTML = `
                    <label for="manufacturer-code" class="form-label">Manufacturer & Item Code</label>
                    <input type="text" id="manufacturer-code" name="bottling_details[${dropdown.name}][manufacturer_code]" class="form-control" placeholder="Enter Manufacturer Code">
                `;

                        // Clear and hide the next row
                        if (nextRow && nextRow.classList.contains('dynamic-row')) {
                            nextRow.innerHTML = '';
                            nextRow.style.display = 'none';
                        }

                        // Remove any ignore attribute
                        dropdown.removeAttribute('data-ignore');
                    }
                }
            });

            // Handle form submission
            document.querySelector('form').addEventListener('submit', function(event) {
                const dropdowns = document.querySelectorAll('.other-option');

                dropdowns.forEach(function(dropdown) {
                    // Check if the dropdown has a corresponding "Other" input field
                    const otherInput = dropdown.closest('.row').querySelector(
                        '.manufacturer-container input');
                    if (dropdown.value === 'Other' && otherInput) {
                        // Update the dropdown value with the dynamic input field's value
                        dropdown.value = otherInput.value;
                    }
                });
            });
        });
    </script>

</body>

</html>
