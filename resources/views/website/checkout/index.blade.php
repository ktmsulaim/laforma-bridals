@extends('layouts.website.secondary', ['title' => 'Checkout'])

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => 'Checkout', 'links' => [
        [
            'url' => route('cart'),
            'label' => 'Checkout'
        ]
    ]])
@endsection

@section('content')
    <checkout-index razorpay_key_id="{{ setting('razorpay_key', env('RAZOR_KEY')) }}"></checkout-index>
@endsection

@push('js_libs')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endpush