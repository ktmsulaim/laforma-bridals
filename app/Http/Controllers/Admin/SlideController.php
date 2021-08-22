<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SlideResource;
use App\Models\Slide;
use Illuminate\Http\Request;
use App\Traits\Controllers\Images;

class SlideController extends Controller
{
    use Images;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.slides.index');
    }

    public function list()
    {
        $slides = Slide::orderBy('order')->orderBy('id', 'desc')->paginate(12);

        return SlideResource::collection($slides);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slides.create');
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
            'base_image' => 'required'
        ]);

        $slide = Slide::create($request->except('base_image'));

        $this->saveImages($request, $slide);

        return response()->json($slide);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', ['slide' => new SlideResource($slide)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slide $slide)
    {
        $slide->update($request->except('base_image'));

        $this->saveImages($request, $slide);

        return response()->json($slide);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        $slide->delete();

        return response()->json([], 204);
    }


    public function sort(Request $request)
    {
        $data = $request->get('slides');

        if($data && is_array($data)) {
            foreach($data as $sorted) {
                $slide = Slide::find($sorted['id']);

                if($slide) {
                    $slide->order = $sorted['position'];
                    $slide->save();
                }
            } 
        }
    }
}
