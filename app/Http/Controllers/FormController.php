<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerInformation;
use App\Models\BottlingDetails;
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{
    public function index(){
        return view('form.index');
    }
    public function store(Request $request)
    {


        // Step 1: Validate the incoming request
        $validatedData = $request->validate([
            //     // Customer Information
            'winery' => 'required|string|max:255',
            'bottling_date' => 'required|date',
            'bottling_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'power' => 'required|string|max:255',
            'special_requirements' => 'nullable|string',

            //     // Bottling Details
            //     'bottling_details' => 'required|array',
            //     'bottling_details.*.service' => 'required|string|max:255',
            //     'bottling_details.*.brand_name' => 'nullable|string|max:255',
            //     'bottling_details.*.year' => 'nullable|integer',
            //     'bottling_details.*.variety' => 'nullable|string|max:255',
            //     'bottling_details.*.volume' => 'nullable|integer',
            //     'bottling_details.*.tank' => 'nullable|string|max:255',
            //     'bottling_details.*.pre_bottling_filtration' => 'nullable|string|max:255',
            //     'bottling_details.*.filtration_bottling' => 'nullable|string|max:255',
            //     'bottling_details.*.gas_protection' => 'nullable|string|max:255',
            //     'bottling_details.*.bottle_type' => 'nullable|string|max:255',
            //     'bottling_details.*.manufacturer_code' => 'nullable|string|max:255',
            //     'bottling_details.*.bottle_color' => 'nullable|string|max:255',
            //     'bottling_details.*.bottle_size' => 'nullable|string|max:255',
            //     'bottling_details.*.closure_type' => 'nullable|string|max:255',
            //     'bottling_details.*.labelling' => 'nullable|string|max:255',
            //     'bottling_details.*.label_height' => 'nullable|integer',
            //     'bottling_details.*.sample_bottle' => 'nullable|boolean',
            //     'bottling_details.*.packing_requirements' => 'nullable|string|max:255',
            //     'bottling_details.*.cartoon' => 'nullable|string|max:255',
        ]);

        // print_r($validatedData['bottling_details']);

        // // Step 2: Save Customer Information
        $customer = new CustomerInformation();
        $customer->winery = $validatedData['winery'];
        $customer->bottling_date = $validatedData['bottling_date'];
        $customer->bottling_address = $validatedData['bottling_address'];
        $customer->city = $validatedData['city'];
        $customer->zip = $validatedData['zip'];
        $customer->contact_person = $validatedData['contact_person'];
        $customer->contact_phone = $validatedData['contact_phone'];
        $customer->email = $validatedData['email'];
        $customer->power = $validatedData['power'];
        $customer->special_requirements = $validatedData['special_requirements'] ?? null;
        $customer->save();

        $bottling_details = $request->bottling_details;
        // // Step 3: Save Bottling Details
        print_r($bottling_details);
        foreach ($bottling_details as $detail) {
            if (isset($detail['service'])) { // Check if the 'service' key exists
                BottlingDetails::create([
                    'customer_id' => $customer->id,
                    'service' => $detail['service'] ?? 'FillLabelBack', // Default service value
                    'brand_name' => $detail['brand_name'] ?? null,
                    'year' => $detail['year'] ?? null,
                    'variety' => $detail['variety'] ?? null,
                    'volume' => $detail['volume'] ?? null,
                    'tank' => $detail['tank'] ?? null,
                    'pre_bottling_filtration' => $detail['pre_bottling_filtration'] ?? null,
                    'filtration_bottling' => $detail['filtration_bottling'] ?? null,
                    'gas_protection' => $detail['gas_protection'] ?? null,
                    'bottle_type' => $detail['bottle_type'] ?? null,
                    'manufacturer_code' => $detail['manufacturer_code'] ?? null,
                    'bottle_color' => $detail['bottle_color'] ?? null,
                    'bottle_size' => $detail['bottle_size'] ?? null,
                    'closure_type' => $detail['closure_type'] ?? null,
                    'labelling' => $detail['labelling'] ?? null,
                    'label_height' => $detail['label_height'] ?? null,
                    'sample_bottle' => $detail['sample_bottle'] ?? null,
                    'packing_requirements' => $detail['packing_requirements'] ?? null,
                    'cartoon' => $detail['cartoon'] ?? null,
                ]);
            } else {
                // Handle the case where 'service' key is missing
                // You can log it, skip it, or provide a default value
                Log::warning('Service key missing in bottling details', $detail);
            }
        }

        // // Step 4: Redirect back with a success message
        return redirect()->back()->with('store_success', 'Form submitted successfully!');
    }
}
