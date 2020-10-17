<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PartPayment extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $renewal;
    public function __construct($renewal)
    {
        //
        $this->renewal = $renewal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject('Payment Update - ' . $this->renewal->practitioner->first_name . ' ' . $this->renewal->practitioner->last_name)
            ->line('New application has been submitted, awaiting review and payment:')
            ->line('Applicant Profession: ' . $this->renewal->practitioner->profession->name . ' and Professional Qualification: ' . $this->renewal->practitioner->professionalQualification->name)
            ->line('Your current balance is: ' . $this->renewal->balance . 'Please complete payment.')
            ->action('View Payment Details', url('/admin/practitioners/' . $this->renewal->practitioner->id));

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
            //
        ];
    }
}
