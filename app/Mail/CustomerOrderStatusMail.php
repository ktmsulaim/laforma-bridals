<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerOrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = "Your order (#{$this->order->id}) status has been changed to {$this->order->status()}";
        $status = $this->order->status;

        if($status === 'completed') {
            $message = "Your order (#{$this->order->id}) has been completed. Happy shopping!";
        } else if($status === 'on_hold') {
            $message = "Sorry! your order (#{$this->order->id}) is on hold. We will notify you whether it's processed or not. Sorry for the inconvenience!";
        } else if($status === 'processing') {
            $message = "Your order (#{$this->order->id}) is being processed! Stay tuned!";
        } else if($status === 'refunded') {
            $message = "We have processed your refund request for your order (#{$this->order->id}). The amount will be deposited to the debited account!";
        } else if($status === 'confirmed') {
            $message = "Congrats! Your order (#{$this->order->id}) has been confirmed. We will notify you when it's processed!";
        }
        

        return $this->to($this->order->customer->email)
                    ->subject('Order ' . $this->order->status())
                    ->markdown('mail.orderStatus', [
                        'order' => $this->order,
                        'message' => $message
                    ]);
    }
}
