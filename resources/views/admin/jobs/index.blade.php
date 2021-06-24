@extends('layouts.admin.base', ['title' => 'Jobs'])

@section('content')
    <div class="row mb-2">
        <div class="col-12 text-right">
            <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary">
                <span class="mdi mdi-plus mr-2"></span>
                <span>Create</span>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <list-jobs></list-jobs>
        </div>
    </div>
@endsection