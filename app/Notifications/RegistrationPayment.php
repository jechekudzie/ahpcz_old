<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationPayment extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $practitioner;

    public function __construct($practitioner)
    {
        //
        $this->practitioner = $practitioner;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //return ['database'];
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
            ->replyTo(User::where('role_id',4)->first()->email)
            ->from(User::where('role_id',4)->first()->email)
            ->subject('Registration Application payment - ' . $this->practitioner->first_name.' '
                .$this->practitioner->last_name)
            ->line('Registration application payment has been made, awaiting your review and approval:')
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
            'comment'=>"A new application payment has been made, please verify this payment for the application to proceed.",
            'title' =>'New Application Payment',
            'sender' => User::where('role_id',4)->first()
        ];
    }
}
