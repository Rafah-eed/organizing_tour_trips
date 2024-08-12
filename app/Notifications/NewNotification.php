<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use JetBrains\PhpStorm\ArrayShape;

class NewNotification extends Notification
{
    use Queueable;

    protected string $message;
    protected ?int $userId; // Add this line

    /**
     * Create a new notification instance.
     *
     * @param  string  $message
     * @param  int|null  $userId
     * @return void
     */
    public function __construct(string $message, ?int $userId = null)
    {
        $this->message = $message;
        $this->userId = $userId; // And this line
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the notification's data array.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    #[ArrayShape(['user_id' => "", 'type' => "string", 'notifiable' => "", 'data' => "array", 'read_at' => "null"])] public function toDatabase(mixed $notifiable)
    {
        return [
            'user_id' => $notifiable->id, // Assuming $notifiable is a user model
            'type' => 'basic', // Or whatever type your notification is
            'notifiable' => $notifiable->toJson(), // Convert the notifiable object to JSON
            'data' => [
                'message' => $notifiable->message, // Assuming $notifiable has a 'message' attribute
                // Add any additional data you want to store
            ],
            'read_at' => null, // Set to null initially; Laravel will update this when the notification is read
        ];
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
