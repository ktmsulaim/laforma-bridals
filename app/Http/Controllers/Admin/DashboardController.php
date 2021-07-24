<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $latestBookings = Booking::latest()->limit(5)->get();
        return view('admin.index', ['bookings' => $latestBookings]);
    }
}
