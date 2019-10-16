<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfficerApproval extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $practitioner;
    protected $comment;

    public function __construct($practitioner, $comment)
    {
        //
        $this->practitioner = $practitioner;
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->replyTo('register@ahpcz.co.zw')
            ->from('register@ahpcz.co.zw')
            ->subject('New Application - ' . $this->practitioner->first_name.' '.$this->practitioner->last_name)
            ->line('New application has been approved by registration officer, awaiting your review and approval:')
            ->line('Applicant Profession: '. $this->practitioner->profession->name. ' and Professional Qualification: ' .$this->practitioner->professionalQualification->name)
            ->line('You can view application details on the link below.')
            ->action('View Application Details', url('/admin/practitioners/' . $this->practitioner->id));



    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id'=>$this->practitioner->id,
            'comment'=>$this->comment,
        ];
    }
}
