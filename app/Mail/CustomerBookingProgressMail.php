<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerBookingProgressMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $booking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = "Your booked package is being processed, and marked as {$this->booking->progress()}";
        
        return $this->to($this->booking->customer->email)
                    ->subject('Package progress updated')
                    ->markdown('mail.booking_progress', [
                        'booking' => $this->booking,
                        'message' => $message,
                    ]);
    }
}
