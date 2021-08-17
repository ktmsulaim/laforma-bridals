<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\AdminNewReviewNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyAdminNewReview
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
        $admins = User::admin()->get();
        Notification::send($admins, new AdminNewReviewNotification($event->review));
    }
}
