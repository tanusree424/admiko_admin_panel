<?php

namespace  App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class POUploadedMail extends Mailable
{
    use Queueable, SerializesModels;


    public $orderNumber;

    public function __construct($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    public function build()
    {
        //return $this->subject(['orderNumber' => $this->orderNumber])
return $this->subject("OrderNumber: #{$this->orderNumber}")
                    ->view('admin.emails.po_uploaded')
                    ->with(['orderNumber' => $this->orderNumber]);
    }
}
