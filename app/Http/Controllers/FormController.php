<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\CustomerInformation;
use App\Models\BottlingDetails;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Array_;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\CustomerDetailsMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;


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
                    'volume' => $bottling_details[$i]['volume'] ?? null,
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
                    'labelling' => $bottling_details[$i]['labeling'],
                    'sample_bottle' => $bottling_details[$i]['sample_bottle'],
                    'label_height' => $bottling_details[$i]['label_height'],
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
                    'volume' => $bottling_details[$i]['volume'] ?? null,
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

                    'bottle_type' =>  $bottling_details[$i]['bottle_type'],
                    'bottle_size' => isset($bottling_details[$i]['bottle_size']) && $bottling_details[$i]['bottle_size'] === "Other"
                        ? ($bottling_details[$i]['bottle_size_other'] ?? null)
                        : ($bottling_details[$i]['bottle_size'] ?? null),
                    'labelling' => $bottling_details[$i]['labeling'],
                    'sample_bottle' => $bottling_details[$i]['sample_bottle'],
                    'label_height' => $bottling_details[$i]['label_height'],
                    'packing_requirements' => $bottling_details[$i]['packing_requirements'],
                    'cartoon' => $bottling_details[$i]['cartoon'] ?? null,
                ]);
            }
        }

        // Retrieve saved bottling details for the customer
        // Generate the PDF and save it in public storage
        $bottlingDetails = BottlingDetails::where('customer_id', $customer->id)->get();
        $pdf = Pdf::loadView('pdf.customer_bottling_details', [
            'customer' => $customer,
            'bottling_details' => $bottlingDetails,
        ])->setPaper('a4', 'landscape');

        $pdfDirectory = public_path('pdfs');
        if (!file_exists($pdfDirectory)) {
            mkdir($pdfDirectory, 0755, true);
        }

        $pdfPath = $pdfDirectory . '/customer_bottling_details_' . $customer->id . '.pdf';
        file_put_contents($pdfPath, $pdf->output());

        // Send email with the PDF attachment
        Mail::to($customer->email)
            ->cc('sales@mwp.com.au')
            ->send(new CustomerDetailsMail($customer, $pdfPath));

        // Redirect to the review page with the PDF path
        return redirect()->route('form.review', ['customer' => $customer->id, 'pdfPath' => $pdfPath]);
    }

    public function review($customerId, Request $request)
    {
        $customer = CustomerInformation::findOrFail($customerId);
        $bottlingDetails = BottlingDetails::where('customer_id', $customerId)->get();
        $pdfPath = $request->query('pdfPath'); // Retrieve PDF path from query

        return view('form.review', compact('customer', 'bottlingDetails', 'pdfPath'));
    }

    public function update(Request $request, $customerId)
    {
        // Validate updated data
        $validatedData = $request->validate([
            'winery' => 'required|string|max:255',
            'bottling_date' => 'required|date',
            'bottling_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            // 'contact_email' => 'required|email|max:255',
            'power' => 'required|string|max:255',
            // Add validation for other fields if necessary
        ]);

        // Prepare customer data as an object
        $customer = (object) $validatedData;

        // Retrieve bottling details from the form
        $bottlingDetails = collect($request->input('bottling_details'))->map(function ($detail) {
            return (object) $detail; // Convert each bottling detail to an object
        });

        // Generate the updated PDF
        $pdf = Pdf::loadView('pdf.customer_bottling_details_update', [
            'customer' => $customer, // Pass the customer as an object
            'bottling_details' => $bottlingDetails, // Pass the bottling details as a collection of objects
        ])->setPaper('a4', 'landscape');

        $pdfPath = 'pdfs/customer_bottling_details_' . $customerId . '_updated.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());

        // Send the updated PDF via email
        Mail::to($validatedData['email'])
            ->cc('sales@mwp.com.au')
            ->send(new CustomerDetailsMail($customer, Storage::disk('public')->get($pdfPath)));

        // Return the updated PDF for download
        return $pdf->download('customer_bottling_details_updated.pdf');
    }
}
