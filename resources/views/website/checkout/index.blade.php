@extends('layouts.website.secondary', ['title' => 'Checkout'])

@section('content')
    @include('components.website.page_header', ['pageTitle' => 'Checkout', 'links' => [
        [
            'url' => route('cart'),
            'label' => 'Checkout'
        ]
    ]])

    <checkout-index :razorpay_key_id='@json(env('RAZOR_KEY'))'></checkout-index>
@endsection

@push('js_libs')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endpush