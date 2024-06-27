<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Parents;


class NotificationEmail extends Notification
{
    use Queueable;

    private $notification;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
        $parent = Parents::find($notification->parent_id);
        $this->user = $parent->user;
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
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->line('Dear ' . $this->user->username . ',')
                    ->line($this->notification->title)
                    ->line($this->notification->message)
                    ->action('Notification Action', url('http://localhost:4200/home'))
                    ->line('Thank you for using our application!')
                    ->salutation(new \Illuminate\Support\HtmlString('Best regards,<br>Nursery Future Minds')); 
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
            'title' => $this->notification->title,
            'message' => $this->notification->message,
        ];
    }
}
