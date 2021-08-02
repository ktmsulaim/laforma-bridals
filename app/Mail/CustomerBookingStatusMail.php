<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerBookingStatusMail extends Mailable
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
        $message = "Your booking status has been changed to {$this->booking->status()}";
        
        return $this->to($this->booking->customer->email)
                    ->subject('Booking status changed')
                    ->markdown('mail.booking_status', [
                        'booking' => $this->booking,
                        'message' => $message,
                    ]);
    }
}
