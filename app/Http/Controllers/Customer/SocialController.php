<?php

namespace App\Http\Controllers\Customer;

use App\Events\CustomerEmailVerified;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function handleProvider($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        
        if(!$user) {
            return response()->json(['error' => "Unable to login with {$provider}"], 500);
        }

        $customer = Customer::where('email', $user->email)->first();
        $username = explode('@', $user->email)[0];

        if($customer) {
            if(!$customer->{$provider .'_id'}) {
                $customer->{$provider . '_id'} = $user->id;
            }
        } else {
            $checkUsername = Customer::where('username', $username)->exists();

            if($checkUsername) {
                $username .= "-1";
            }

            $customer = Customer::create([
                $provider .'_id' => $user->id,
                'name' => $user->name,
                'photo' => $user->getAvatar(),
                'email' => $user->email,
                'username' => $username,
                'phone' => 0,
                'email_verified_at' => Carbon::now(),
                'is_active' => 1,
            ]);

            event(new Registered($customer));
            CustomerEmailVerified::dispatch($customer);

        }

        auth('customer')->login($customer);


        return response()->json([
            'user' => $customer,
            'token' => csrf_token(),
        ]);
    }

    public function callback(Request $request, $provider)
    {
        // $user = Socialite::driver($provider)->stateless()->user();
        // return response()->json($user);
        return view('customer.auth.social');
    }
}
