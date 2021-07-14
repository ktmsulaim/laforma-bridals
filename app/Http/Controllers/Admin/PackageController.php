<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Traits\Controllers\Images;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Redirect;

class PackageController extends Controller
{

    use Images;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $packages = Package::latest()->get();
            $packages = $packages->transform(function($package){
                return [
                    'id' => $package->id,
                    'name' => $package->name,
                    'base_image' => $package->baseImage(),
                    'status' => $package->status,
                    'features' => $package->features,
                    'price' => $package->price(),
                    'booking_price' => $package->booking_price,
                    'created' => $package->created_at->format('d F, Y')
                ];
            });
            
            return response()->json($packages);
        }
        return view('admin.packages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->data();

        $data = $request->except(['base_image', 'additional_images']);

        $data['slug'] = $request->get('slug') ?: str_slug($request->name);

        $package = Package::create($data);

        $this->saveImages($request, $package);

        return response()->json($package);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $package->{'base_image'} = $package->images()->wherePivot('type', '=', 'base_image')->first();
        $package->{'additional_images'} = $package->images()->wherePivot('type', '=', 'additional_images')->get();
        return view('admin.packages.edit', ['package' => $package]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $this->data();

        $data = $request->except(['base_image', 'additional_images']);

        if(($data['name'] != $package->name) && !$request->get('slug')) {
            $data['slug'] = str_slug($data['name']);
        }

        $package->update($data);

        $this->saveImages($request, $package);

        return response()->json($package);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        if($package->images()->exists()) {
            $package->images()->detach();
        }

        // Delete it self
        $package->delete();

        Toastr::success('The package has been deleted', 'Success');

        return Redirect::route('admin.packages.index');
    }

    private function data() {
        request()->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'features' => 'required',
            'hours' => 'required',
            'price' => 'required',
            'booking_price' => 'required',
            'booking_price_type' => 'required',
            'base_image' => 'required'
        ]);
    }
}
