<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public function index()
    {
        return view('admin.tags.index');
    }

    public function getList()
    {
        $tags = Tag::all()->transform(function($tag) {
            return [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
                'created_at' => $tag->created_at->format('d F, Y')
            ];
        });

        return response()->json($tags);
    }

    public function store(Request $request)
    {
        
    }

    public function destroy(Tag $tag)
    {
        
    }
}
