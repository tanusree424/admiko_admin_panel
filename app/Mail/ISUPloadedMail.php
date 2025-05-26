<?php

namespace  App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ISUploadedMail extends Mailable
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
                    ->view('admin.emails.is_uploaded')
                    ->with(['orderNumber' => $this->orderNumber]);
    }
}
