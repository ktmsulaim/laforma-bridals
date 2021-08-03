<?php

namespace App\Http\Controllers\Admin;

use App\Events\BookingProgressChanged;
use App\Events\BookingStatusChanged;
use App\Http\Controllers\Controller;
use App\Mail\CustomerBookingStatusMail;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ManageBookings extends Controller
{
    public function index()
    {
        return view('admin.bookings.index');
    }

    public function list(Request $request)
    {
        if($request->has('filter')) {
            $start = $request->has('date_range') ? $request->get('date_range')[0] : null;
            $end = $request->has('date_range') ? $request->get('date_range')[1] : null;
            $status = $request->get('status');
            $progress = $request->get('progress');
            $package = $request->get('package');

            $bookings = Booking::orderBy('date', 'desc')->orderBy('time', 'ASC');


            if($start) {
                $bookings->where('date', '>=', Carbon::parse($start));
            }

            if($end) {
                $bookings->where('date', '<=', Carbon::parse($end));
            }

            if($status) {
                $bookings->where('status', $status);
            }
            
            if($progress) {
                $bookings->where('progress', $progress);
            }

            if($package) {
                $bookings->whereHas('package', function($query) use($package) {
                    $query->where('name', $package);
                });
            }
            
            $bookings = $bookings->get();

            $count = count($bookings);
        } else {
            $bookings = Booking::orderBy('id', 'desc');
            $count = Booking::count();

            if($request->has('search')) {
                $search = $request->get('search');
                $bookings = Booking::whereHas('customer', function($query) use($search){
                    $query->where('name', 'like', "%$search%");
                    $query->orWhere('phone', '=', $search);
                })->orWhereHas('package', function($query) use($search) {
                    $query->where('name', 'like', "%$search%");
                });
    
                $count = $bookings->count();
            } 
            
            if($request->has('limit') && $request->has('offset')) {
               $bookings = $bookings->limit($request->get('limit'))->offset($request->get('offset'))->get();
            } else {
                $bookings = $bookings->get();
            }
        }
        

        $bookings = $bookings->transform(function ($booking) {
            return [
                'id' => $booking->id,
                'customer_name' => $booking->customer->name,
                'customer_phone' => $booking->customer->phone,
                'package' => $booking->package->name,
                'date' => $booking->date(),
                'time' => $booking->time,
                'status' => $booking->status(),
                'progress' => $booking->progress(),
                'url' => [
                    'view' => route('admin.bookings.show', $booking->id)
                ]
            ];
        });

        $data = [
            'data' => $bookings,
            'count' => $count
        ];

        return response()->json($data);
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', ['booking' => $booking]);
    }

    public function print(Booking $booking)
    {
        return view('admin.bookings.print', ['booking' => $booking]);
    }

    public function status(Request $request, Booking $booking)
    {
        $status = $request->get('status');

        if(!$status) {
            return response()->json(['error' => 'Status couldn\'t be found'], 422);
        }

        if($status === 'cancelled') {
            $booking->cancelled = 1;
            $booking->cancelled_by = 'admin';
            $booking->cancelled_by_id = auth()->id();
            $booking->cancelled_at = Carbon::now();
        } else {
            $booking->cancelled = 0;
        }

        $booking->status = $status;
        $booking->save();

        // event
        if(setting('email_notification') === 'enable' && setting('booking_status_mail') === 'enable') {
            event(new BookingStatusChanged($booking));
        }

        $booking = $booking->fresh();
        return response()->json($booking->status());
    }

    public function progress(Request $request, Booking $booking)
    {
        $progress = $request->get('progress');

        if(!$progress) {
            return response()->json(['error' => 'Progress can\'t be empty'], 422);
        }

        $booking->progress = $progress;
        $booking->save();

        // event
        if(setting('email_notification') === 'enable' && setting('booking_progress_mail') === 'enable') {
            event(new BookingProgressChanged($booking));
        }
        
        $booking = $booking->fresh();
        return response()->json($booking->progress());
    }

    // public function test()
    // {
    //     return new CustomerBookingStatusMail(Booking::first());
    // }
}
