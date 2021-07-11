<?php

namespace App\Listeners;

use App\Mail\CustomerOrderStatusMail;
use App\Notifications\NotifyCustomerOrderStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $order = $event->order;
        $order->customer->notify(new NotifyCustomerOrderStatus($order));
    }
}
