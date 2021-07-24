<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
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

        $bookings = $bookings->transform(fn ($booking) => [
            'id' => $booking->id,
            'package' => $booking->package->name,
            'date' => $booking->date(),
            'time' => $booking->time,
            'status' => $booking->status(),
            'progress' => $booking->progress(),
            'booked_on' => $booking->created_at->format('d F, \'y'),
            'url' => [
                'view' => route('customer.bookings.show', $booking->id)
            ]
        ]);

        return response()->json($bookings);
    }
}
