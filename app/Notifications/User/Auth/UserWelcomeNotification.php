<?php

namespace App\Notifications\User\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserWelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
        $url = "https://student-amnesty.wufpbk.edu.ng/";

        return (new MailMessage)
            ->subject('Welcome to ' . config('app.name'))
            ->line('Dear,' . $notifiable->first_name)
            ->line('Your email address is now confirmed!')
            ->line('Your email address is now confirmed!')
            ->line('Welcome to the ' . config('app.name') . 'community')
            ->line('To personalize your experience, please complete your profile by clicking this link:');
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