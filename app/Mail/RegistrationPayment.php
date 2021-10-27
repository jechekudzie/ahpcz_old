<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationPayment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $practitioner;
    public function __construct($practitioner)
    {
        //
        $this->practitioner = $practitioner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->practitioner->contact->email)
            ->subject( 'Final Registration Payment '.$this->practitioner->first_name.' '.$this->practitioner->last_name)
            ->markdown('mail.registration_payment');
    }
}
