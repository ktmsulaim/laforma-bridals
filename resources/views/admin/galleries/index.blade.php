@extends('layouts.admin.base', ['title' => 'Gallery'])

@section('content')
    <div class="row mb-2">
        <div class="col-12 text-right">
            <a href="{{ route('admin.galleries.create')}}" class="btn btn-primary"><span class="mdi mdi-plus"></span> Create</a>
        </div>
    </div>
    <list-galleries></list-galleries>
@endsection