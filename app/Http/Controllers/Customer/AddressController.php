<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $addresses = request()->user('customer')->addresses;
    
            return AddressResource::collection($addresses);
        }

        return view('customer.address.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateData();

        $address = request()->user('customer')->addresses()->create($request->all());

        $this->clearDefault($address);

        return new AddressResource($address);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        $this->validateData();

        if(request()->user('customer')->id === $address->customer_id) {
            $this->clearDefault($address);

            $address->update($request->all());
            $address = $address->fresh();

            return new AddressResource($address);
        } else {
            return response()->json(['message' => 'The address doesn\'t belong to you!'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        if(request()->user('customer')->id === $address->customer_id) {
            $address->delete();

            return response()->json([], 201);
        } else {
            return response()->json(['message' => 'The address doesn\'t belong to you!'], 403);
        }
    }

    private function validateData()
    {
        return request()->validate([
            'full_name' => 'required|max:50',
            'address_line1' => 'required',
            'address_line2' => '',
            'city' => 'required',
            'district' => 'required',
            'state' => 'required',
            'phone' => 'required|integer',
            'pincode' => 'required|integer|digits:6',
            'landmark' => '',
            'is_default' => ''
        ]);
    }

    /**
     * Clear the default address if any address becomes default
     * 
     * @param \App\Models\Address  $address
     * @return null
     */
    public function clearDefault(Address $address)
    {   
        if(request()->has('is_default') && 
            request()->get('is_default')) 
        {
            Address::where('id', '!=', $address->id)->each(function($address){
                $address->is_default = 0;
                $address->save();
            });
        }
    }
}
