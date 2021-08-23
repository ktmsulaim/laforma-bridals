<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $latestBookings = Booking::latest()->limit(5)->get();
        $today = Carbon::today();

        // counts
        $productsCount = Product::available()->count();
        $packagesCount = Package::available()->count();
        $ordersCount = Order::where('created_at', '>=', $today->startOfMonth())->where('created_at', '<=', $today)->count();
        $bookingsCount = Booking::where('created_at', '>=', $today->startOfMonth())->where('created_at', '<=', $today)->count();

        return view('admin.index', 
        [
            'latestBookings' => $latestBookings,
            'products' => $productsCount,
            'packages' => $packagesCount,
            'orders' => $ordersCount,
            'bookings' => $bookingsCount,
        ]);
    }
}
