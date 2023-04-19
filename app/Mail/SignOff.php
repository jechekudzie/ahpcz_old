<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignOff extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $renewal;

    public function __construct($renewal)
    {
        //
        $this->renewal = $renewal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('registrar@ahpcz.co.zw')
            ->subject(date('Y') . ' Practising Certificate')
            ->markdown('mail.signoff');
    }
}
