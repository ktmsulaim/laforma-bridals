@extends('layouts.admin.base', ['title' => 'Packages'])

@section('content')
    <div class="row mb-2">
        <div class="col-md-12 text-right">
            <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
                <span class="mdi mdi-plus mr-2"></span>
                <span>Create new</span>
            </a>
        </div>
    </div>
   <list-packages></list-packages>
@endsection