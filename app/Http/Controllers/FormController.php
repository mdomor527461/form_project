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
            'power' => 'required|string|max:255',
            'special_requirements' => 'nullable|string',
        ]);

        $customer = new CustomerInformation();
        $customer->fill($validatedData);
        $customer->save();

        $bottling_details = $request->input('bottling_details');
        // print_r($bottling_details);
        if (!is_array($bottling_details)) {
            return back()->withErrors(['bottling_details' => 'Invalid bottling details submitted']);
        }
        // print_r($bottling_details);
        // $details = [];
        for ($i = 1; $i <= count($bottling_details); $i++) {
            $details = [];
            if ($i == 1) {
                $service = $bottling_details[$i]['service'];
                // echo $bottling_details[$i]['service']." ";
                continue;
            }
            else{
               if(count($bottling_details[$i]) ==18 || count($bottling_details[$i]) ==19){

                $service = "FillLabelPack";
               }
               else if(count($bottling_details[$i]) ==16 || count($bottling_details[$i]) == 15){
                     $service = "FillPack";
               }
               else if(count($bottling_details[$i]) ==12 || count($bottling_details[$i]) == 11){
                    $service = "LabelPack";
               }
            }

            foreach ($bottling_details[$i] as $single_detail) {
                array_push($details, $single_detail);
            }
            // echo count($bottling_details[$i])." ";
            // echo $service." ";
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
