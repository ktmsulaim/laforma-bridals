@extends('layouts.admin.base', ['title' => 'Slides'])

@section('content')
    <div class="row mb-2">
        <div class="col text-right">
            <a href="{{ route('admin.slides.create')}}" class="btn btn-primary"><span class="mdi mdi-plus"></span> Create</a>
        </div>
    </div>
    <list-slides></list-slides>
@endsection