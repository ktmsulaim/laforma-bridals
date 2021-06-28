<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class AdminCustomersController extends Controller
{
    public function index()
    {
        return view('admin.customers.index');
    }

    public function listCustomers(Request $request)
    {
        /**
         * Filters:
         * 1. Status - [0 => Inactive, 1 => Active]
         * 2. Verified - [0 => Not verified, ]
         */
    }

    public function show(Customer $customer)
    {
        
    }

    public function update(Request $request, Customer $customer)
    {   
        
    }
}
