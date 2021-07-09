@extends('layouts.customer.base', ['title' => 'Orders','pageTitle' => 'Orders', 'pageSubTitle' => 'Manage your orders here'])

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.customer.navigation')
        </div>
        <div class="col-md-9">
            <list-orders></list-orders>
        </div>
    </div>
@endsection