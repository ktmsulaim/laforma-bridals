@extends('layouts.customer.base', ['title' => 'Bookings','pageTitle' => 'Bookings', 'pageSubTitle' => 'Manage your bookings here'])

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.customer.navigation')
        </div>
        <div class="col-md-9">
            <list-bookings></list-bookings>
        </div>
    </div>
@endsection