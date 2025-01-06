<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $pdfContent;

    public function __construct($customer, $pdfContent)
    {
        $this->customer = $customer;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Customer Bottling Details')
            ->view('emails.customer_details')
            ->attachData($this->pdfContent, 'customer_bottling_details.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
