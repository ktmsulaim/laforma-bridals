<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
        $customer = Customer::find(auth('customer')->id());
        return view('customer.auth.account', ['customer' => $customer]);
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
