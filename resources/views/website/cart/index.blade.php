@extends('layouts.website.secondary', ['title' => 'Cart'])

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => 'Cart', 'links' => [
        [
            'url' => route('cart'),
            'label' => 'Cart'
        ]
    ]])
@endsection

@section('content')
    <cart-index></cart-index>
@endsection