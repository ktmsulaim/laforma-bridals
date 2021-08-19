<?php

namespace App\Http\Controllers;

use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;

class WebsiteGalleryController extends Controller
{
    public function index()
    {
        return view('website.galleries.index');
    }

    public function show($slug)
    {
        $gallery = Gallery::findBySlug($slug);

        return view('website.galleries.show', ['gallery' => $gallery]);
    }

    public function list()
    {
        $galleries = Gallery::available()->orderBy('id', 'desc')->get();
        
        return GalleryResource::collection($galleries);
    }

    public function byCollection($id)
    {
        $gallery = Gallery::find($id);
        
        if(!$id || !$gallery) {
            return response()->json(['error' => "Unable to find the collection"], 404);
        }

        return response()->json($gallery->additionalImages());
     }
}
