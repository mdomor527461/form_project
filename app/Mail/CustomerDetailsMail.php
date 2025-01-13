<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class CustomerDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $pdfContent;
    public $recipientType;
    public $reviewLink;

    public function __construct($customer, $pdfContent, $recipientType, $reviewLink = null)
    {
        $this->customer = $customer;
        $this->pdfContent = $pdfContent;
        $this->recipientType = $recipientType;
        $this->reviewLink = $reviewLink;
    }

    public function build()
    {
        $bottlingDate = Carbon::parse($this->customer->bottling_date)->format('d/m/Y');

        $subject = $this->recipientType === 'winemaker'
            ? "MWP Bottling Summary for ($bottlingDate)"
            : "Bottling Summary - {$this->customer->winery} ($bottlingDate)";

        return $this->subject($subject)
            ->view('emails.customer_details')
            ->attachData($this->pdfContent, 'customer_bottling_details.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
