<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where(['status' => 1, 'slug' => $slug])->firstOrFail();

        return view('website.pages.show', ['page' => $page]);
    }
}
