<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerInformation;
use App\Models\BottlingDetails;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Array_;
use Barryvdh\DomPDF\Facade\Pdf;

class FormController extends Controller
{
    public function index()
    {
        return view('form.index');
    }
    public function store(Request $request)
    {
        // Validate and save customer information
        $validatedData = $request->validate([
            'winery' => 'required|string|max:255',
            'bottling_date' => 'required|date',
            'bottling_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'contact_email' => 'required|email|max:255',
            'power' => 'required|string|max:255',
            'special_requirements' => 'nullable|string',
        ]);

        $customer = new CustomerInformation();
        $customer->fill($validatedData);
        $customer->save();

        $bottling_details = $request->input('bottling_details');
        // print_r($bottling_details);
        // echo $bottling_details[2]['tank'];
        if (!is_array($bottling_details)) {
            return back()->withErrors(['bottling_details' => 'Invalid bottling details submitted']);
        }
        // print_r($bottling_details);
        // $details = [];
        for ($i = 1; $i <= count($bottling_details); $i++) {
            // $details = [];
            if ($i == 1) {
                $service = $bottling_details[$i]['service'];
                // echo $bottling_details[$i]['service']." ";
                // echo $service." 1st ";
                continue;
            } else {

                $service = end($bottling_details[$i - 1]);
                //  echo $service." last er gula";
                // print_r($bottling_details[$i]);


            }
            // print_r($bottling_details);
            // foreach ($bottling_details[$i] as $single_detail) {
            //     array_push($details, $single_detail);
            // }
            // echo count($bottling_details[$i])." ";
            // echo $service." ";
            if ($service == "FillLabelPack") {
                BottlingDetails::create([
                    'customer_id' => $customer->id, // Replace with actual customer ID
                    'service' => $service,
                    'year' => $bottling_details[$i]['year'],
                    'brand_name' => $bottling_details[$i]['brand_name'],
                    'variety' => $bottling_details[$i]['variety'],
                    'tank' =>  $bottling_details[$i]['tank'],
                    'pre_bottling_filtration' =>  $bottling_details[$i]['pre_bottling_filtration'],
                    'filtration_bottling' =>  $bottling_details[$i]['filtration_bottling'],
                    'gas_protection' =>  $bottling_details[$i]['gas_protection'],
                    'bottle_type' =>  $bottling_details[$i]['bottle_type'],
                    'bottle_color' => isset($bottling_details[$i]['bottle_color']) && $bottling_details[$i]['bottle_color'] === "Other"
                        ? ($bottling_details[$i]['bottle_color_other'] ?? null)
                        : ($bottling_details[$i]['bottle_color'] ?? null),
                    'bottle_size' => isset($bottling_details[$i]['bottle_size']) && $bottling_details[$i]['bottle_size'] === "Other"
                        ? ($bottling_details[$i]['bottle_size_other'] ?? null)
                        : ($bottling_details[$i]['bottle_size'] ?? null),
                    'manufacturer_code' => $bottling_details[$i]['manufacturer_code'],
                    'closure_type' => $bottling_details[$i]['closure_type'],
                    'closure_description' => $bottling_details[$i]['closure_description'] ?? null,
                    'apply_capsule' => $bottling_details[$i]['apply_capsule'] ?? null,
                    'capsule_description' => $bottling_details[$i]['capsule_description'] ?? null,
                    'packing_requirements' => $bottling_details[$i]['packing_requirements'],
                    'cartoon' => $bottling_details[$i]['cartoon'] ?? null,
                ]);
            } else if ($service == "FillPack") {
                BottlingDetails::create([
                    'customer_id' => $customer->id, // Replace with actual customer ID
                    'service' => $service,
                    'year' => $bottling_details[$i]['year'],
                    'brand_name' => $bottling_details[$i]['brand_name'],
                    'variety' => $bottling_details[$i]['variety'],
                    'tank' =>  $bottling_details[$i]['tank'],
                    'pre_bottling_filtration' =>  $bottling_details[$i]['pre_bottling_filtration'],
                    'filtration_bottling' =>  $bottling_details[$i]['filtration_bottling'],
                    'gas_protection' =>  $bottling_details[$i]['gas_protection'],
                    'bottle_type' =>  $bottling_details[$i]['bottle_type'],
                    'bottle_color' => isset($bottling_details[$i]['bottle_color']) && $bottling_details[$i]['bottle_color'] === "Other"
                    ? ($bottling_details[$i]['bottle_color_other'] ?? null)
                    : ($bottling_details[$i]['bottle_color'] ?? null),
                    'bottle_size' => isset($bottling_details[$i]['bottle_size']) && $bottling_details[$i]['bottle_size'] === "Other"
                    ? ($bottling_details[$i]['bottle_size_other'] ?? null)
                    : ($bottling_details[$i]['bottle_size'] ?? null),
                    'manufacturer_code' => $bottling_details[$i]['manufacturer_code'],
                    'closure_type' => $bottling_details[$i]['closure_type'],
                    'closure_description' => $bottling_details[$i]['closure_description'] ?? null,
                    'apply_capsule' => $bottling_details[$i]['apply_capsule'] ?? null,
                    'capsule_description' => $bottling_details[$i]['capsule_description'] ?? null,
                    'packing_requirements' => $bottling_details[$i]['packing_requirements'],
                    'cartoon' => $bottling_details[$i]['cartoon'] ?? null,
                ]);
            } else if ($service == "LabelPack") {
                BottlingDetails::create([
                    'customer_id' => $customer->id, // Replace with actual customer ID
                    'service' => $service,
                    'year' => $bottling_details[$i]['year'],
                    'brand_name' => $bottling_details[$i]['brand_name'],
                    'variety' => $bottling_details[$i]['variety'],
                    'volume' => $bottling_details[$i]['volume'] ?? null,
                    'pre_bottling_filtration' =>  $bottling_details[$i]['pre_bottling_filtration'],
                    'filtration_bottling' =>  $bottling_details[$i]['filtration_bottling'],
                    'gas_protection' =>  $bottling_details[$i]['gas_protection'],
                    'bottle_type' =>  $bottling_details[$i]['bottle_type'],
                   'bottle_size' => isset($bottling_details[$i]['bottle_size']) && $bottling_details[$i]['bottle_size'] === "Other"
                    ? ($bottling_details[$i]['bottle_size_other'] ?? null)
                    : ($bottling_details[$i]['bottle_size'] ?? null),
                    'packing_requirements' => $bottling_details[$i]['packing_requirements'],
                    'cartoon' => $bottling_details[$i]['cartoon'] ?? null,
                ]);
            }
        }

        // Retrieve saved bottling details for the customer
        $bottlingDetails = BottlingDetails::where('customer_id', $customer->id)->get();
        $pdf = Pdf::loadView('pdf.customer_bottling_details', [
            'customer' => $customer,
            'bottling_details' => $bottlingDetails,
        ])->setPaper('a4', 'landscape'); // Set the paper size to A4 and orientation to landscape

        // Return the generated PDF for download
        return $pdf->download('customer_bottling_details_landscape.pdf');
    }
}
