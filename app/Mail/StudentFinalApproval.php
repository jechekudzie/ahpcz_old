<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentFinalApproval extends Mailable
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
            ->subject('Application  Approval - Approved')
            ->markdown('mail.student_final_approval');
    }

}
