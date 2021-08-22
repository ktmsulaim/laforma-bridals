<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.index');
    }

    public function list()
    {
        $pages = Page::orderBy('id', 'desc')->get();
        $pages = $pages->transform(fn($page)=>[
            'id' => $page->id,
            'title' => $page->title,
            'status' => $page->status,
            'created' => $page->created_at->format('d F, Y'),
            'url' => route('admin.pages.edit', $page->id), 
        ]);
        
        return response()->json($pages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.pages.create");
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
            'title' => 'required|string',
            'slug' => 'required',
        ]);

        $data = $request->all();
        
        if(!$data['slug']) {
            $data['slug'] = str_slug($request->title);
        }

        $page = Page::create($data);

        return response()->json($page);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', ['page' => $page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required',
        ]);

        $data = $request->all();
        
        if(!$data['slug']) {
            $data['slug'] = str_slug($request->title);
        }

        $page->update($data);

        return response()->json($page);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        
        return response()->json([], 204);
    }
}
