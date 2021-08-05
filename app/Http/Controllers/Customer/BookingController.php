<?php

namespace App\Http\Controllers\Customer;

use App\Events\CustomerCancelledBookingEvent;
use App\Events\CustomerChangedBookingTimeEvent;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function show(Booking $booking)
    {
        if(request()->user('customer')->id !== $booking->customer_id) {
            return redirect()->route('customer.bookings');
        }

        return view('customer.bookings.show', ['booking' => $booking]);
    }

    public function list(Request $request)
    {
        $filter = $request->get('filter');
        
        if($filter) {
            $bookings = request()->user('customer')->bookings()->where('status', $filter)->get();
        } else {
            $bookings = request()->user('customer')->bookings()->get();
        }

        $currentYear = Carbon::now()->year;

        $bookings = $bookings->transform(fn ($booking) => [
            'id' => $booking->id,
            'package' => $booking->package->name,
            'date' => $booking->date(),
            'time' => $booking->time,
            'status' => $booking->status(),
            'progress' => $booking->progress(),
            'booked_on' => $booking->created_at->year === $currentYear ? $booking->created_at->format('d F') : $booking->created_at->format('d F, \'y'),
            'url' => [
                'view' => route('customer.bookings.show', $booking->id)
            ]
        ]);

        return response()->json($bookings);
    }

    public function changeTime(Request $request) {
        $bookingId = $request->get('booking_id');
        $newDate = $request->get('new_date');
        $newTime = $request->get('new_time');

        if(!$bookingId || !$newDate || !$newTime) {
            return response()->json(['error' => 'Invalid data is provided'], 422);
        }

        $booking = Booking::find($bookingId);

        if(!$booking) {
            return response()->json(['error' => 'Booking was not found!'], 404);
        } else if($booking->customer->id !== $request->user('customer')->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        if(!$booking->package->isAvailableOn($newDate)) {
            return response()->json(['error' => 'Sorry! selected date is not available'], 400); 
        }
        
        $booking->date = $newDate;
        $booking->time = $newTime;
        $booking->save();

        // event -> notify admin
        event(new CustomerChangedBookingTimeEvent($booking));

        return response()->json($booking->fresh());
    }

    public function cancel(Booking $booking)
    {
        $booking->status = 'cancelled';
        $booking->cancelled = 1;
        $booking->cancelled_by = 'customer';
        $booking->cancelled_by_id = $booking->customer_id;
        $booking->cancelled_at = Carbon::now();
        $booking->save();

        //event -> notify admin
        event(new CustomerCancelledBookingEvent($booking));

        return response()->json($booking->fresh());
    }
}
