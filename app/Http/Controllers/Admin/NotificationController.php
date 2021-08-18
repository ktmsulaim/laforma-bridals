<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Money;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function listUnread(Request $request)
    {
        $admin = $request->user();
        $notifications = $admin->unreadNotifications;

        $data = [];

        if($notifications && count($notifications)) {
            foreach($notifications as $notification) {
                $type = str_replace('App\\Notifications\\', '', $notification->type);

                $single = [
                    'url' => null,
                    'id' => $notification->id,
                    'photo' => asset('img/customer.png'),
                    'title' => null,
                    'message' => null,
                    'time' => $notification->created_at->diffForHumans()
                ];

                if($type === 'NewCustomerRegistered') {
                    $customer = Customer::find($notification->data['id']);

                    if($customer) {
                        $single['photo'] = $customer->photo();
                        $single['title'] = 'New customer';
                        $single['message'] = '<b>'.$customer->name . '</b> has created an account!';
                        $single['url'] = route('admin.customers.show', $customer->id);
                    }
                } else if($type === 'NewOrderPlaced') {
                    $order = Order::find($notification->data['order_id']);

                    if($order) {
                        $single['photo'] = $order->customer->photo();
                        $single['title'] = 'New order';
                        $single['message'] = '<b>'. $order->customer->name . '</b> placed an order! <br> Products: <b>'. $order->products->count() .'</b> , Amount: <b>' . Money::format($order->total) .'</b>';
                        $single['url'] = route('admin.orders.show', $order->id);
                    }
                } else if($type === 'NewBookingNotification' || $type === 'BookingTimeChangedNotification' || $type === 'BookingCancelledNotification') {
                    $booking = Booking::find($notification->data['booking_id']);
                    $notificationData = $notification->data;
                    $title = null;
                    $message = null;
                    

                    if($booking) {
                        if($type === 'NewBookingNotification') {
                            $title = 'New booking';
                            $message = '<b>'.$booking->customer->name . '</b> booked appointment for ' . $notificationData['package']. ' on ' . $notificationData['time'] . '@' . $notificationData['date'];
                        } else if ($type === 'BookingTimeChangedNotification') {
                            $title = 'Booking time changed';
                            $message = '<b>'.$booking->customer->name . "</b> has changed their booking time to {$notificationData['time']}@{$notificationData['date']} "; 
                        } else if ($type === 'BookingTimeChangedNotification') {
                            $title = 'Booking cancelled';
                            $message = "<b>{$booking->customer->name}</b> cancelled their appointment";
                        }

                        $single['photo'] = $booking->customer->photo();
                        $single['title'] = $title;
                        $single['message'] = $message;
                        $single['url'] = route('admin.bookings.show', $booking->id);
                    }
                } else if($type === 'AdminNewReviewNotification') {
                    $notificationData = $notification->data;
                    $review = Review::find($notificationData['review_id']);

                    if($review && $review->customer) {
                        $single['photo'] = $review->customer->photo();
                    }

                    $single['title'] = "New review";
                    $single['message'] = "{$notificationData['customer']} has posted a new review on {$notificationData['product']}";
                    $single['url'] = route('admin.reviews.show', $notificationData['review_id']);
                }

                array_push($data, $single);

            }
        }

        if($data && count($data)) {
            foreach($data as $key => $item) {
                if(!$item['title']) {
                    array_splice($data, $key, 1);
                }
            }
        } 


        return response()->json($data);
    }

    public function markAsRead(Request $request)
    {
        $notificationId = $request->get('notification_id');
        $notification = $request->user()->notifications->find($notificationId);

        if(!$notification || !$notificationId) {
            return response()->json(['error' => "Notification not found"], 404);
        }

        $notification->markAsRead();

        return response()->json(true);
    }

    public function markAllAsRead(Request $request)
    {
        $notifications = $request->user()->unreadNotifications;

        if($notifications) {
            $notifications->markAsRead();
        }

        return response()->json(true);
    }
}
