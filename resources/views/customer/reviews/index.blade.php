@extends('layouts.customer.base', ['title' => 'Reviews','pageTitle' => 'Reviews', 'pageSubTitle' => 'Manage your reviews here'])

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.customer.navigation')
        </div>
        <div class="col-md-9">
            <list-reviews></list-reviews>
        </div>
    </div>
@endsection