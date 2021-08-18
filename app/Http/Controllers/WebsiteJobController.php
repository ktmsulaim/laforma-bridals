<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class WebsiteJobController extends Controller
{
    public function index()
    {
        $jobs = Job::available()->orderBy('id', 'desc')->paginate(10);
        return view('website.jobs.index', ['jobs' => $jobs]);
    }

    public function show($slug)
    {
        $job = Job::whereSlug($slug)->first();

        return view('website.jobs.show', ['job' => $job]);
    }
}
