<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Traits\Controllers\Images;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Redirect;

class ServiceController extends Controller
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
            $services = Service::latest()->get();
            $services = $services->transform(function($service){
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'base_image' => $service->baseImage(),
                    'status' => $service->status,
                    'features' => $service->features,
                    'price' => $service->price(),
                    'created' => $service->created_at->format('d F, Y')
                ];
            });
            
            return response()->json($services);
        }
        return view('admin.services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.create');
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

        $service = Service::create($data);

        $this->saveImages($request, $service);

        return response()->json($service);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $service->{'base_image'} = $service->images()->wherePivot('type', '=', 'base_image')->first();
        $service->{'additional_images'} = $service->images()->wherePivot('type', '=', 'additional_images')->get();
        return view('admin.services.edit', ['service' => $service]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $this->data();

        $data = $request->except(['base_image', 'additional_images']);

        if(($data['name'] != $service->name) && !$request->get('slug')) {
            $data['slug'] = str_slug($data['name']);
        }

        $service->update($data);

        $this->saveImages($request, $service);

        return response()->json($service);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        if($service->images()->exists()) {
            $service->images()->detach();
        }

        // Delete it self
        $service->delete();

        Toastr::success('The service has been deleted', 'Success');

        return Redirect::route('admin.services.index');
    }

    private function data() {
        request()->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'features' => 'required',
            'hours' => 'required',
            'price' => 'required',
            'base_image' => 'required'
        ]);
    }
}
