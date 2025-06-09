<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BroadcastMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public $subject;
    public $message;

    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->line($this->message)
            ->action('View in Dashboard', url('/dashboard'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'subject' => $this->subject,
            'message' => $this->message,
            'url' => url('/dashboard')
        ];
    }
}