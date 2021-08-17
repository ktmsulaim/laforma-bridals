@extends('layouts.customer.base', ['title' => 'Wishlist','pageTitle' => 'Wishlist', 'pageSubTitle' => 'Manage your favourite products here'])

@section('content')
    <div class="row">
        <div class="col-lg-3">
            @include('components.customer.navigation')
        </div>
        <div class="col-lg-9">
            <list-wishlist></list-wishlist>
        </div>
    </div>
@endsection