<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Traits\Controllers\Images;

class GalleryController extends Controller
{
    use Images;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.galleries.index');
    }

    public function list()
    {
        $galleries = Gallery::orderBy('id', 'desc')->paginate(12);
        return GalleryResource::collection($galleries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => '',
            'status' => 'required',
            'thumbnail' => 'required',
            'images' => 'required',
        ]);

        $gallery = Gallery::create($request->only('name', 'slug', 'description', 'status'));

        $this->saveImages($request, $gallery, 'thumbnail', 'images');

        return response()->json($gallery);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        $gallery->{'base_image'} = $gallery->getBaseImage();
        $gallery->{'additional_images'} = $gallery->additionalImages();

        return view('admin.galleries.edit', ['gallery' => $gallery]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => '',
            'status' => 'required',
            'thumbnail' => 'required',
            'images' => 'required',
        ]);

        $gallery->update($request->only('name', 'slug', 'description', 'status'));

        $this->saveImages($request, $gallery, 'thumbnail', 'images');

        return response()->json($gallery);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //
    }
}
