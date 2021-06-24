<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Controllers\Images;
use Brian2694\Toastr\Facades\Toastr;

class JobController extends Controller
{
    use Images;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.jobs.index');
    }

    public function listJobs()
    {
        $jobs = Job::latest()->get();

        $jobs = $jobs->transform(function($job){
            return [
                'image' => $job->baseImage(),
                'id' => $job->id,
                'title' => $job->title,
                'for' => ucfirst($job->for),
                'type' => ucfirst($job->type),
                'status' => $job->status,
                'created_at' => $job->created_at->format('d F, Y'),
                'edit' => route('admin.jobs.edit', ['job' => $job->id]),
            ];
        });

        return response()->json($jobs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.jobs.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateData();
        
        $data = $request->except(['base_image']);
        
        $data['slug'] = $request->get('slug') ?: str_slug($data['title']);

        $job = Job::create($data);

        $this->saveImages($request, $job);

        return response()->json($job);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        $job->{'base_image'} = $job->images()->wherePivot('type', '=', 'base_image')->first();
        return view('admin.jobs.edit', ['job' => $job]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $this->validateData();

        $data = $request->except(['base_image']);

        if($request->get('slug') != $job->slug) {
            $data['slug'] = $request->get('slug') ?: str_slug($data['title']);
        }
        

        $job->update($data);

        $this->saveImages($request, $job);

        return response()->json($job);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        if($job->images()->exists()) {
            $job->images()->detach();
        }

        $job->delete();

        Toastr::success('The job has been deleted', 'Success');

        return redirect()->route('admin.jobs.index');
    }

    private function validateData()
    {
        request()->validate([
            'title' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'for' => 'required',
            'type' => 'required',
        ]);
    }
}
