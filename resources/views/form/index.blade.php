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
            <h3 style="margin-left:20px;">Booking Form</h3>
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
                        <label for="bottling-address" class="form-label">Address *</label>
                        <input type="text" id="bottling-address" name="bottling_address" class="form-control"
                            placeholder="Street Address" required>
                        <div class="text-danger mt-1">Address details are required.</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="city" name="city" class="form-control mt-2" placeholder="City / Locality"
                            required>
                        <div class="text-danger mt-1">Address details are required.</div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="zip" name="zip" class="form-control mt-2"
                            placeholder="Post Code" required>
                        <div class="text-danger mt-1">Address details are required.</div>
                    </div>
                </div>
                <div class="row mb-3">
                   <div class="col-md-8 d-flex justify-content-between gap-4">
                        <div style="width: 100%;">
                            <label for="contact-person" class="form-label">Winemaker / Contact person*</label>
                            <input type="text" id="contact-person" name="contact_person" class="form-control"
                                placeholder="Full Name" required>
                        </div>
                        <div style="width: 100%;">
                            <label for="email" class="form-label">Email*</label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="Email Address" required>
                        </div>
                        <div style="width: 100%;">
                            <label for="contact-phone" class="form-label">Phone *</label>
                            <input type="text" id="contact-phone" name="contact_phone" class="form-control"
                                placeholder="Phone Number" required>
                        </div>
                   </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="email" class="form-label">Accounts Email *</label>
                        <input type="email" id="email" name="contact_email" class="form-control"
                            placeholder="Email Address" required>
                    </div>
                    <div class="col-md-4">
                        <label for="power" class="form-label">Power Supply*</label>
                        <select id="power" name="power" class="form-select" required>
                            <option value="">Select Power Requirement</option>
                            <option value="Single Phase">Power Supplied(32 Amp,5 Pin)</option>
                            <option value="MWP Generator">MWP Generator required</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Bottling Details -->
            <h3 class="section-title" style="margin-left:20px;">Bottling Details</h3>
            <div class="section-container">
                <div id="product-list"></div>
                <button type="button" class="btn btn-add btn-sm mb-3" id="add-product">+ Add Wine</button>
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
                            <h5 class="section-title">Wine</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="year" class="form-label">Year *</label>
                                        <input type="number" id="year" name="bottling_details[${wineCounter}][year]" class="form-control" placeholder="Enter Year" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="brand-name" class="form-label">Brand Name *</label>
                                        <input type="text" id="brand-name" name="bottling_details[${wineCounter}][brand_name]" class="form-control" placeholder="Enter Brand Name" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="variety" class="form-label">Variety/Name *</label>
                                        <input type="text" id="variety" name="bottling_details[${wineCounter}][variety]" class="form-control" placeholder="Enter Variety/Name" required>
                                    </div>
                                <div class="col-md-4">
                                        <label for="tank" class="form-label">Tank/Vessel Identifier</label>
                                        <input type="text" id="tank" name="bottling_details[${wineCounter}][tank]" class="form-control" placeholder="Enter Tank/Vessel Number">
                                    </div>
                                </div>


                                <h5 class="section-title">Bottle</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="bottle-type-${wineCounter}" class="form-label">Bottle Type *</label>
                                        <select id="bottle-type-${wineCounter}" name="bottling_details[${wineCounter}][bottle_type]" class="form-select other-option" required>
                                            <option value="">Select Bottle Type</option>
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
                                        <label for="bottle-color" class="form-label">Colour</label>
                                        <select id="bottle-color-${wineCounter}" name="bottling_details[${wineCounter}][bottle_color]" class="form-select other-option">
                                            <option value="">Select Bottle Colour</option>
                                            <option value="Flint">Flint</option>
                                            <option value="Antique Green">Antique Green</option>
                                            <option value="French Green">French Green</option>
                                            <option value="Amber">Amber</option>
                                            <option value="Arctic Blue">Arctic Blue</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3" id="man-aft-${wineCounter}">
                                    <div class="col-md-4">
                                        <label for="manufacturer-code-${wineCounter}" class="form-label">Manufacturers Product Code</label>
                                        <input type="text" id="manufacturer-code-${wineCounter}" name="bottling_details[${wineCounter}][manufacturer_code]" class="form-control" placeholder="Enter Manufacturer Code">
                                    </div>
                                </div>

                                <h5 class="section-title">Closure </h5>
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
                                <h5 class="section-title">Packaging</h5>
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
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            `;
                    } else if (e.target.value === 'FillPack') {
                        fields.innerHTML = `
                                 <h5 class="section-title">Wine</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="year" class="form-label">Year *</label>
                                        <input type="number" id="year" name="bottling_details[${wineCounter}][year]" class="form-control" placeholder="Enter Year" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="brand-name" class="form-label">Brand Name *</label>
                                        <input type="text" id="brand-name" name="bottling_details[${wineCounter}][brand_name]" class="form-control" placeholder="Enter Brand Name" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="variety" class="form-label">Variety/Name *</label>
                                        <input type="text" id="variety" name="bottling_details[${wineCounter}][variety]" class="form-control" placeholder="Enter Variety/Name" required>
                                    </div>
                                <div class="col-md-4">
                                        <label for="tank" class="form-label">Tank/Vessel Identifier</label>
                                        <input type="text" id="tank" name="bottling_details[${wineCounter}][tank]" class="form-control" placeholder="Enter Tank/Vessel Number">
                                    </div>
                                </div>


                                <h5 class="section-title">Bottle</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="bottle-type-${wineCounter}" class="form-label">Bottle Type *</label>
                                        <select id="bottle-type-${wineCounter}" name="bottling_details[${wineCounter}][bottle_type]" class="form-select other-option" required>
                                            <option value="">Select Bottle Type</option>
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
                                        <label for="bottle-color" class="form-label">Colour</label>
                                        <select id="bottle-color-${wineCounter}" name="bottling_details[${wineCounter}][bottle_color]" class="form-select other-option">
                                            <option value="">Select Bottle Colour</option>
                                            <option value="Flint">Flint</option>
                                            <option value="Antique Green">Antique Green</option>
                                            <option value="French Green">French Green</option>
                                            <option value="Amber">Amber</option>
                                            <option value="Arctic Blue">Arctic Blue</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3" id="man-aft-${wineCounter}">
                                    <div class="col-md-4">
                                        <label for="manufacturer-code-${wineCounter}" class="form-label">Manufacturers Product Code</label>
                                        <input type="text" id="manufacturer-code-${wineCounter}" name="bottling_details[${wineCounter}][manufacturer_code]" class="form-control" placeholder="Enter Manufacturer Code">
                                    </div>
                                </div>

                                <h5 class="section-title">Closure </h5>
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
                                <h5 class="section-title">Packaging</h5>
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
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            `;
                    } else if (e.target.value === 'LabelPack') {
                        fields.innerHTML = `
                        <h5 class="section-title">Wine </h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="year" class="form-label">Year *</label>
                                <input type="number" id="year" name="bottling_details[${wineCounter}][year]" class="form-control" placeholder="Enter Year" required>
                            </div>
                            <div class="col-md-4">
                                <label for="brand-name" class="form-label">Brand Name *</label>
                                <input type="text" id="brand-name" name="bottling_details[${wineCounter}][brand_name]" class="form-control" placeholder="Enter Brand Name" required>
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

                        <h5 class="section-title">Bottle </h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="bottle-type" class="form-label">Bottle Type *</label>
                                <select id="bottle-type" name="bottling_details[${wineCounter}][bottle_type]" class="form-select other-option" required>
                                   <option value="">Select Bottle Type</option>
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
                                <div class="other-input-container col-md-4"></div>
                        </div>

                        <h5 class="section-title">Packaging</h5>
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
                                    <option value="Other">Other</option>
                                </select>
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
                    // Get the current row, other-input-container, and dynamic row
                    const row = dropdown.closest('.row');
                    const wineIndex = dropdown.name.match(/\[(\d+)\]/)[1];
                    const otherInputContainer = row.querySelector('.other-input-container');
                    const manPrev = document.getElementById(`man-pre-${wineIndex}`);
                    const manAfter = document.getElementById(`man-aft-${wineIndex}`);
                    const bottleSizePrev = document.getElementById(`bottle-size-prev-${wineIndex}`);
                    const bottleSizeNext = document.getElementById(`bottle-size-next-${wineIndex}`);
                    const sizeSpecify = document.getElementById(`size-specify-${wineIndex}`);
                    // If "Other" is selected bottle type and manufacturer
                    if (dropdown.id === `bottle-type-${wineIndex}` && dropdown.value === 'Other') {
                        otherInputContainer.style.display = 'block';
                        manPrev.style.display = 'none';
                        manAfter.style.display = 'block';
                        // Find the label for the current dropdown
                        const label = row.querySelector(`label[for="${dropdown.id}"]`);
                        const labelText = label ? label.textContent.replace('*', '').trim() : 'Other';

                        // Add dynamic input field in the `other-input-container`
                        otherInputContainer.innerHTML = `
                        <label for="${dropdown.name}_other" class="form-label">${labelText} (Other)</label>
                        <input type="text" name="${dropdown.name}_other" class="form-control" placeholder="Please specify" required>
                    `;
                    } else if (dropdown.id === `bottle-type-${wineIndex}`) {
                        otherInputContainer.style.display = 'none';
                        manPrev.style.display = 'block';
                        manAfter.style.display = 'none';
                    }
                    //color and size
                    if (dropdown.id === `bottle-color-${wineIndex}` && dropdown.value === 'Other') {
                        otherInputContainer.style.display = 'block';
                        bottleSizePrev.style.display = 'none';
                        bottleSizeNext.style.display = 'block';
                        // Find the label for the current dropdown
                        const label = row.querySelector(`label[for="${dropdown.id}"]`);
                        const labelText = label ? label.textContent.replace('*', '').trim() : 'Other';

                        // Add dynamic input field in the `other-input-container`
                        otherInputContainer.innerHTML = `
                        <label for="${dropdown.name}_other" class="form-label">${labelText}(Other)</label>
                        <input type="text" name="${dropdown.name}_other" class="form-control" placeholder="Please specify" required>
                    `;
                    } else if (dropdown.id === `bottle-color-${wineIndex}`) {
                        otherInputContainer.style.display = 'none';
                        bottleSizePrev.style.display = 'block';
                        bottleSizeNext.style.display = 'none';
                    }

                    if (dropdown.id === `bottle-size-${wineIndex}` && dropdown.value === 'Other') {
                        sizeSpecify.style.display = 'block';
                        console.log("hello");
                    } else if (dropdown.id === `bottle-size-${wineIndex}`) {
                        sizeSpecify.style.display = 'none';
                    }
                    //genarel
                    else if (dropdown.value === 'Other') {
                        // Find the label for the current dropdown
                        const label = row.querySelector(`label[for="${dropdown.id}"]`);
                        const labelText = label ? label.textContent.replace('*', '').trim() : 'Other';

                        // Add dynamic input field in the `other-input-container`
                        otherInputContainer.innerHTML = `
                    <label for="${dropdown.name}_other" class="form-label">${labelText} (Other)</label>
                    <input type="text" name="${dropdown.name}_other" class="form-control" placeholder="Please specify" required>
                `;
                    } else {
                        // Clear the container if "Other" is not selected
                        otherInputContainer.innerHTML = '';
                    }
                }
            });

            // Handle form submission
            document.querySelector('form').addEventListener('submit', function(event) {
                const dropdowns = document.querySelectorAll('.other-option');
                dropdowns.forEach(function(dropdown) {
                    // Check if the dropdown has a corresponding "Other" input field
                    const otherInput = dropdown.closest('.row').querySelector(
                        '.other-input-container input');
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
