<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PractitionerApprovalStage2 extends Mailable
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
        return $this->from('registrations@ahpcz.co.zw')
            ->subject($this->practitioner->first_name.' '.$this->practitioner->last_name. '- Application Final  Approval')
            ->markdown('mail.approval_stage2');
    }
}
