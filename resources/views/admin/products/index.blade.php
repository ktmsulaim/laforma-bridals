@extends('layouts.admin.base', ['title' => 'Products'])

@section('content')
    <div class="row">
        <div class="col text-right">
            <a href="{{ route('admin.products.create')}}" class="btn btn-primary"><span class="mdi mdi-plus"></span> Create</a>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection