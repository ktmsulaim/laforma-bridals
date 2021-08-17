<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.dashboard');
    }

    public function orders()
    {
        return view('customer.orders.index');
    }

    public function bookings()
    {
        return view('customer.bookings.index');
    }
    
    public function account()
    {
        
    }
   
    public function wishlist()
    {
        return view('customer.wishlist.index');
    }
    
    public function reviews()
    {
        return view('customer.reviews.index');
    }
}
