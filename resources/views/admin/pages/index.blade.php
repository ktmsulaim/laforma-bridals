@extends('layouts.admin.base', ['title' => 'Pages'])

@section('content')
    <div class="row mb-2">
        <div class="col text-right">
            <a href="{{ route('admin.pages.create')}}" class="btn btn-primary"><span class="mdi mdi-plus"></span> Create</a>
        </div>
    </div>
    <list-pages></list-pages>
@endsection