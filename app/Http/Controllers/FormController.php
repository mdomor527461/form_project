<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerInformation;
use App\Models\BottlingDetails;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Array_;

class FormController extends Controller
{
    public function index()
    {
        return view('form.index');
    }
    public function store(Request $request)
    {
        // // Step 1: Validate the incoming request
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

        $customer_information = [];
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


        $bottling_details = $request->input('bottling_details'); // Get 'bottling_details'
        // Log the data to debug
        // Log::info('Bottling Details:', $bottling_details);

        // Print the data (for local debugging)
        // dd($bottling_details);
        if (!is_array($bottling_details)) {
            return back()->withErrors(['bottling_details' => 'Invalid bottling details submitted']);
        }
        $details = [];
        // print_r($details);
        for ($i = 1; $i <= count($bottling_details); $i++) {
            $details = []; // Reset $details at the start of each iteration
            // Add customer ID to the details array
            if ($i == 1) {
                $service = $bottling_details[$i]['service'];
                continue;
            }
            // array_push($details,$customer->id);
            // print_r($details);
            foreach ($bottling_details[$i] as $single_detail) {
                array_push($details, $single_detail);
                // echo "$single_detail<br>";
                // echo " $single_detail "; // Add each detail to the $details array
            }

            // Optionally, remove the first element (if necessary)


            print_r($details);
            // echo $details[5];
            if($service == "FillLabelPack"){
            BottlingDetails::create([
                'customer_id' => $customer->id, // Replace with actual customer ID
                'service' => $service,
                'brand_name' => $details[0],
                'year' => $details[1],
                'variety' => $details[2],
                'volume' => $details[3],
                'tank' => $details[4],
                'pre_bottling_filtration' => $details[5],
                'filtration_bottling' => $details[6],
                'gas_protection' => $details[7],
                'bottle_type' => $details[8],
                'manufacturer_code' => $details[9],
                'bottle_color' => $details[10],
                'bottle_size' => $details[11],
                'closure_type' => $details[12],
                'labelling' => $details[13],
                'label_height' => $details[14],
                'sample_bottle' => $details[15],
                'packing_requirements' => $details[16],
                'cartoon' => $details[17],

            ]);
        }
        else if($service == "FillPack"){
            BottlingDetails::create([
                'customer_id' => $customer->id, // Replace with actual customer ID
                'service' => $service,
                'brand_name' => $details[0],
                'year' => $details[1],
                'variety' => $details[2],
                'volume' => $details[3],
                'tank' => $details[4],
                'pre_bottling_filtration' => $details[5],
                'filtration_bottling' => $details[6],
                'gas_protection' => $details[7],
                'bottle_type' => $details[8],
                'manufacturer_code' => $details[9],
                'bottle_color' => $details[10],
                'bottle_size' => $details[11],
                'closure_type' => $details[12],
                'packing_requirements' => $details[13],
                'cartoon' => $details[14],
            ]);
        }
        else if($service == "LabelPack"){
            BottlingDetails::create([
                'customer_id' => $customer->id, // Replace with actual customer ID
                'service' => $service,
                'brand_name' => $details[0],
                'year' => $details[1],
                'variety' => $details[2],
                'volume' => $details[3],
                'bottle_type' => $details[4],
                'bottle_size' => $details[5],
                'labelling' => $details[6],
                'label_height' => $details[7],
                'sample_bottle' => $details[8],
                'packing_requirements' => $details[9],
                'cartoon' => $details[10],
            ]);
        }
            // Print the current $details array
            // Clear $details for the next iteration
            // This step is redundant here since $details is reset at the beginning of the loop
        }
        return back()->with('store_success','form submitted successfully');
    }
}
