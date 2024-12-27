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
                // echo $service." 1st ";
                continue;
            }
            else{

                 $service = end($bottling_details[$i-1]);
                //  echo $service." last er gula";
                // print_r($bottling_details[$i]);


            }
            // print_r($bottling_details);
            foreach ($bottling_details[$i] as $single_detail) {
                array_push($details, $single_detail);
            }
            // echo count($bottling_details[$i])." ";
            // echo $service." ";
            if($service == "FillLabelPack"){
                BottlingDetails::create([
                    'customer_id' => $customer->id, // Replace with actual customer ID
                    'service' => $service,
                    'year' => $details[0],
                    'brand_name' => $details[1],
                    'variety' => $details[2],
                    'tank' => $details[3],
                    'bottle_type' => $details[4],
                    'bottle_color' => $details[5],
                    'manufacturer_code' => $details[6],
                    'closure_type' => $details[7],
                    'packing_requirements' => $details[8],
                ]);
            }
            else if($service == "FillPack"){
                BottlingDetails::create([
                    'customer_id' => $customer->id, // Replace with actual customer ID
                    'service' => $service,
                    'year' => $details[0],
                    'brand_name' => $details[1],
                    'variety' => $details[2],
                    'tank' => $details[3],
                    'bottle_type' => $details[4],
                    'bottle_color' => $details[5],
                    'manufacturer_code' => $details[6],
                    'closure_type' => $details[7],
                    'packing_requirements' => $details[8],
                ]);
            }
            else if($service == "LabelPack"){
                BottlingDetails::create([
                    'customer_id' => $customer->id, // Replace with actual customer ID
                    'service' => $service,
                    'year' => $details[0],
                    'brand_name' => $details[1],
                    'variety' => $details[2],
                    'volume' => $details[3],
                    'bottle_type' => $details[4],
                    'packing_requirements' => $details[5],
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
