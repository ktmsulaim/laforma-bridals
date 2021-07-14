<?php

namespace App\Http\Controllers;

use App\Http\Resources\PackageResource;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebsitePackageController extends Controller
{
    public function index()
    {
        $packages = Package::available()->get();
        return view('website.packages.index', ['packages' => $packages]);   
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

    public function checkAvailability(Request $request, Package $package)
    {
        $date = $request->get('date');

        if(!$request->has('date') || !$date) {
            return response()->json(['error' => 'Date must be specified'], 422);
        }

        $date = Carbon::parse($date);

        
    }
}
