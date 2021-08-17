<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNewReviewNotification extends Notification
{
    use Queueable;

    protected $review;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($review)
    {
        $this->review = $review;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'review_id' => $this->review->id,
            'customer' => $this->review->customer->name,
            'product' => $this->review->product->name,
        ];
    }
}
