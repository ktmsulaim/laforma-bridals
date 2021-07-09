@extends('layouts.customer.base', ['title' => 'Addresses','pageTitle' => 'Addresses', 'pageSubTitle' => 'Manage your saved addresses here'])

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.customer.navigation')
        </div>
        <div class="col-md-9">
            <customer-address></customer-address>
        </div>
    </div>
@endsection