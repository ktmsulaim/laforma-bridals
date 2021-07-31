<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        
    }

    public function invoice($type)
    {
        
    }
}
