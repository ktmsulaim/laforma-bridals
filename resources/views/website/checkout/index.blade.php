@extends('layouts.website.secondary', ['title' => 'Checkout'])

@section('content')
    @include('components.website.page_header', ['pageTitle' => 'Checkout', 'links' => [
        [
            'url' => route('cart'),
            'label' => 'Checkout'
        ]
    ]])

    <checkout-index></checkout-index>
@endsection