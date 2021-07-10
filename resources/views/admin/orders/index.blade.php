@extends('layouts.admin.base', ['title' => 'Orders'])

@section('content')
    <div class="row">
        <div class="col text-right">
            <button class="btn btn-secondary"><span class="mdi mdi-filter"></span> Filter</button>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <list-orders></list-orders>
        </div>
    </div>
@endsection