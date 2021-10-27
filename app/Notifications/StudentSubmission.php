<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentSubmission extends Notification
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
            ->replyTo($this->practitioner->contact->email)
            ->from($this->practitioner->contact->email)
            ->subject('Student Registration Application - ' . $this->practitioner->first_name.' '
                .$this->practitioner->last_name)
            ->line('Student application has been submitted by '. $this->practitioner->first_name.' '
                .$this->practitioner->last_name. ', awaiting review:')
            ->line('You can view application details on the link below.')
            ->action('View Application Details', url('/admin/students/' . $this->practitioner->id));

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
            'comment'=>"A new student registration application has been submitted. Please go through and verify.",
            'title' =>'Practitioner Registration Application',
            'sender' => User::where('role_id',3)->first()
        ];
    }
}
