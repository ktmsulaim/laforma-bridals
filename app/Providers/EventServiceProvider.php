<?php

namespace App\Providers;

use App\Events\BookingProgressChanged;
use App\Events\BookingStatusChanged;
use App\Events\CustomerCancelledBookingEvent;
use App\Events\CustomerChangedBookingTimeEvent;
use App\Events\CustomerEmailVerified;
use App\Events\NewBookingMade;
use App\Events\NewOrderPlaced;
use App\Events\OrderStatusChanged;
use App\Listeners\NotifyAdminBookingCancellation;
use App\Listeners\NotifyAdminBookingTimeChange;
use App\Listeners\SendBookingConfirmationToCustomer;
use App\Listeners\SendBookingProgressMail;
use App\Listeners\SendBookingStatusMail;
use App\Listeners\SendCustomerWelcomeMail;
use App\Listeners\SendNewBookingNotificationToAdmin;
use App\Listeners\SendNewCustomerAdminNotification;
use App\Listeners\SendNewOrderNotification;
use App\Listeners\SendOrderStatusMail;
use App\Listeners\SendOrderSummaryToCustomer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendNewCustomerAdminNotification::class,
        ],
        CustomerEmailVerified::class => [
            SendCustomerWelcomeMail::class
        ],
        NewOrderPlaced::class => [
            SendOrderSummaryToCustomer::class,
            SendNewOrderNotification::class,
        ],
        OrderStatusChanged::class => [
            SendOrderStatusMail::class,
        ],
        NewBookingMade::class => [
            SendBookingConfirmationToCustomer::class,
            SendNewBookingNotificationToAdmin::class,
        ],
        BookingStatusChanged::class =>  [
            SendBookingStatusMail::class
        ],
        BookingProgressChanged::class => [
            SendBookingProgressMail::class
        ],
        CustomerChangedBookingTimeEvent::class => [
            NotifyAdminBookingTimeChange::class
        ],
        CustomerCancelledBookingEvent::class => [
            NotifyAdminBookingCancellation::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
