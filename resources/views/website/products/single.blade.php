@extends('layouts.website.secondary', ['title' => $product->name])

@push('meta')
    <meta name="title" content="{{ $product->meta_title }}">
    <meta name="description" content="{{ $product->meta_description }}">

    <meta property="og:title" content="{{ $product->meta_title }}" />
    <meta property="og:description" content="{{ $product->meta_description }}" />
    <meta property="og:image" content="{{ $product->baseImage() }}" />
@endpush

@section('content')
    @include('components.website.page_header', ['pageTitle' => $product->name, 'links' => [
        [
            'url' => 'javascript:void(0)',
            'label' => 'Products'
        ],
        [
            'url' => route('singleProduct', $product->slug),
            'label' => $product->name
        ]
    ]])
@endsection

@section('content_fluid')
    <single-product :product-id="{{ $product->id }}"></single-product>
    <div class="feat">
        <div class="container">
            <ul>
                <li>
                    <div class="box">
                        <i class="ti-gift"></i>
                        <div class="justify-content-center">
                            <h3>Free Shipping</h3>
                            <p>For all oders</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="box">
                        <i class="ti-wallet"></i>
                        <div class="justify-content-center">
                            <h3>Secure Payment</h3>
                            <p>100% secure payment</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="box">
                        <i class="ti-headphone-alt"></i>
                        <div class="justify-content-center">
                            <h3>24/7 Support</h3>
                            <p>Online top support</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection