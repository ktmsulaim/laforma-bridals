@extends('layouts.customer.base', ['title' => 'Dashboard','pageTitle' => 'Dashboard', 'pageSubTitle' => 'Welcome ' . auth('customer')->user()->name])

@section('content')
    {{-- @include('components.website.page_header', ['pageTitle' => 'Dashboard', 'links' => [
        [
            'url' => 'javascript:void(0)',
            'label' => 'Customer'
        ],
        [
            'url' => route('customer.dashboard'),
            'label' => 'Dashboard'
        ]
    ]]) --}}
    <div class="main_title">
        <h2>Account overview</h2>
        <p>Navigate to your desired location</p>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <a class="box_topic_2" href="{{ route('customer.address.index') }}">
            <i class="mdi mdi-map-marker-outline"></i>
            <h3>Addresses</h3>
            <p>Manage your addresses which can be used while placing orders</p>
        </a>
        </div>
        <div class="col-md-6">
            <a class="box_topic_2" href="#0">
            <i class="ti-user"></i>
            <h3>Account</h3>
            <p>Manage your personal info. You can update your registered mobile number and email address here</p>
        </a>
        </div>
    </div>
    <!-- /row -->
    
    <div class="row">
        <div class="col-md-6">
            <a class="box_topic_2" href="#0">
            <i class="ti-package"></i>
            <h3>Orders</h3>
            <p>Manage your orders. You can view and make changes to your orders here</p>
        </a>
        </div>
        <div class="col-md-6">
            <a class="box_topic_2" href="#0">
            <i class="mdi mdi-calendar-check"></i>
            <h3>Bookings</h3>
            <p>Manage your service bookings here. Know the status, cancel booking, change the date.etc</p>
        </a>
        </div>
    </div>
    <!-- /row -->
    
    <div class="row">
        <div class="col-md-6">
            <a class="box_topic_2" href="#0">
            <i class="mdi mdi-heart-circle-outline"></i>
            <h3>Wishlist</h3>
            <p>Manage your wished products. You can order it any time you want easily</p>
        </a>
        </div>
        <div class="col-md-6">
            <a class="box_topic_2" href="#0">
            <i class="ti-comments"></i>
            <h3>Reviews</h3>
            <p>Manage your reviews. You can edit or delete the reviews here</p>
        </a>
        </div>
    </div>
    <!-- /row -->	

@endsection