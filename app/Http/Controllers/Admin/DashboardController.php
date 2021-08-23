<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Product;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $latestBookings = Booking::latest()->limit(5)->get();
        $today = Carbon::today();

        // counts
        $productsCount = Product::available()->count();
        $packagesCount = Package::available()->count();
        $ordersCount = Order::where('created_at', '>=', $today->startOfMonth())->count();
        $bookingsCount = Booking::where('created_at', '>=', $today->startOfMonth())->count();

        // Data for orders and bookings
        $period = CarbonPeriod::create(Carbon::now()->subMonths(6), '1 month', Carbon::now());
        $data = [
            'orders' => [],
            'bookings' => [],
        ];

        if($period && count($period)) {
            foreach($period as $month) {
                // $data['orders'] = ;

                array_push($data['orders'], [
                    'month' => $month->format('M'),
                    'total' => Order::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->sum('total')
                ]);
                
                array_push($data['bookings'], [
                    'month' => $month->format('M'),
                    'total' => $this->getBookingMonthlyIncome($month)
                ]);
            }
        }

        // Latest 5 customers
        $customers = Customer::latest()->limit(5)->get();

        return view('admin.index', 
        [
            'latestBookings' => $latestBookings,
            'products' => $productsCount,
            'packages' => $packagesCount,
            'orders' => $ordersCount,
            'bookings' => $bookingsCount,
            'chart' => $data,
            'customers' => $customers,
        ]);
    }

    private function getBookingMonthlyIncome(Carbon $month) {
        $bookingCharge = Payment::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->sum('amount');
        $bookings = Booking::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->get();
        $packageAmount = 0;
        
        if($bookings && count($bookings)) {
            
            foreach($bookings as $booking) {
                if(!$booking->cancelled && $booking->status === 'completed') {
                    $packageAmount += $booking->package->price;
                }
            }
        }

        return $bookingCharge + $packageAmount;
    }
}
