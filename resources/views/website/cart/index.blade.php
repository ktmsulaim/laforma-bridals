@extends('layouts.website.secondary', ['title' => 'Cart'])

@section('content')
    @include('components.website.page_header', ['pageTitle' => 'Cart', 'links' => [
        [
            'url' => route('cart'),
            'label' => 'Cart'
        ]
    ]])

    <cart-index></cart-index>
@endsection