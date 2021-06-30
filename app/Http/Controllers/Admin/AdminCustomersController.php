<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

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
         * 2. Verified - [0 => Not verified, 1 => Verified]
         * 3. All
         */
        $filter = $request->get('filter');
        $status = $request->get('status');
        $verified = $request->get('verification');

        if($filter && $filter == 1) {
            if(!$request->has('status') && !$request->has('verification')) {
                $customers = Customer::active()->latest()->get();
            } else {
                $customers = Customer::where(function($query) use($status, $verified){
                    if(!is_null($status)) {
                        $query->where('is_active', $status);
                    }
    
                    if(!is_null($verified)) {
                        if($verified == 1) {
                            $query->whereNotNull('email_verified_at');
                        } else {
                            $query->whereNull('email_verified_at');
                        }
                    }
                })->orderBy('id', 'desc')->get();
            }
        } else {
            $customers = Customer::active()->latest()->get();
        }

        $customers = $customers->transform(function($customer){
            return [
                'id' => $customer->id,
                'photo' => $customer->photo(),
                'name' => $customer->name,
                'phone' => $customer->phone,
                'verified' => optional($customer->email_verified_at)->diffForHumans(),
                'status' => $customer->isActive(),
                'created' => $customer->created_at->format('d F, Y'),
                'view' => route('admin.customers.show', $customer->id),
            ];
        });

        return response()->json($customers);
    }

    public function show(Customer $customer)
    {
        
    }

    public function update(Request $request, Customer $customer)
    {   
        
    }
}
