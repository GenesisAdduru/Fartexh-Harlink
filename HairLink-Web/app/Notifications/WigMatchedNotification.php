<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WigMatchedNotification extends Notification
{
    use Queueable;

    public $hairRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct($hairRequest)
    {
        $this->hairRequest = $hairRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Good news! A wig match has been found')
            ->greeting('Hello ' . $notifiable->first_name . '!')
            ->line('We are happy to inform you that a wig has been matched to your request #' . $this->hairRequest->reference . '.')
            ->line('Our team is now preparing the wig for shipment.')
            ->action('Track Your Request', url('/recipient/tracking/' . $this->hairRequest->reference))
            ->line('Thank you for being part of the HairLink community!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
