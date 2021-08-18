<?php

namespace App\Http\Controllers;

use App\Events\NewBookingMade;
use App\Http\Resources\PackageResource;
use App\Models\Booking;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebsitePackageController extends Controller
{
    public function index()
    {
        return view('website.packages.index');   
    }

    public function list()
    {
        $packages = Package::available()->get();

        return PackageResource::collection($packages);
    }


    public function show($slug)
    {
        $package = Package::findBySlug($slug);

        return view('website.packages.show', ['package' => $package]);
    }

    public function get(Package $package)
    {
        if(request()->ajax()) {
            return new PackageResource($package);
        }
    }

    public function checkAvailability(Request $request, Package $package)
    {
        $date = $request->get('date');

        if(!$request->has('date') || !$date) {
            return response()->json(['error' => 'Date must be specified'], 422);
        }

        $availability = $package->getAvailableSlots($date);

        return response()->json($availability);
    }

    public function book(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer',
            'package_id' => 'required|integer',
            'date' => 'required',
            'time' => 'required',
            'progress' => 'required',
            'status' => 'required'
        ]);

        $booking = Booking::create($request->all());

        if(setting('email_notification') === 'enable' && setting('booking_confirmation_mail') === 'enable') {
            event(new NewBookingMade($booking));
        }


        return response()->json($booking);
    }
}
