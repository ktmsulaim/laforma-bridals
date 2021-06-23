@extends('layouts.admin.base', ['title' => 'Services'])

@section('content')
    <div class="row mb-2">
        <div class="col-md-12 text-right">
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                <span class="mdi mdi-plus mr-2"></span>
                <span>Create new</span>
            </a>
        </div>
    </div>
   <list-services></list-services>
@endsection