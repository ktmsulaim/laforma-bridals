<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function basic(Request $request)
    {
        $customer = Customer::find(auth('customer')->id());
        
        $validations = [
            'name' => 'required',
            'username' => 'required|unique:customers,username,' . $customer->id,
            'phone' => 'required|numeric|unique:customers,phone,' . $customer->id,
        ];
        
        $data = $request->only('name', 'username', 'phone');

        if($request->has('password') && !empty($request->get('password'))) {
            $validations['password'] = 'required|min:8|confirmed';
            $data['password'] = Hash::make($request->get('password'));
        }

        $request->validate($validations);

        $customer->update($data);

        return response()->json($customer);
    }

    public function photo(Request $request)
    {
        $request->validate([
            'file' => 'required|file|image|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ]);

        if($request->has('file') && $request->file('file')->isValid()) {
            $imageName = Storage::putFile('customers', $request->file('file'));
            $image = Image::make(Storage::url($imageName))->resize(400, 400, function($constraints){
                $constraints->aspectRatio();
            })->save(storage_path('app/public/' . $imageName));

            $customer = Customer::find(auth('customer')->id());

            if($customer) {
                $customer->photo = $imageName;
                $customer->save();
            }

            return response()->json(['file' => Storage::url($imageName)]);
        }

        return response()->json(['error' => "Unable to find an image"], 404);
    }
}
