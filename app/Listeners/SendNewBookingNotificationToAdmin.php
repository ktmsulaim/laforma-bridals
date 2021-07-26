<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewBookingNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewBookingNotificationToAdmin
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
        $admin = User::admin()->get();
        Notification::send($admin, new NewBookingNotification($event->booking));
    }
}
