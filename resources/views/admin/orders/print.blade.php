@extends('layouts.admin.base', ['title' => 'Print invoice - Order #'. $order->id])

@section('content')
    <div class="row">
        <div class="col text-right">
            <print-invoice source="order-{{ $order->id }}"
                :styles='@json([asset("assets/app/css/bootstrap.min.css"), asset("assets/app/css/icons.min.css"), asset('assets/app/css/admin.css')])'></print-invoice>
        </div>
    </div>
    <div class="card card-body" id="order-{{ $order->id }}">
        <div class="row p-4">
            <div class="col-6">
                <img src="{{ asset('img/2.png') }}" width="150" alt="">
            </div>
            <div class="col-6">
                <div class="text-right">
                    <h1>INVOICE</h1>
                    <p>Date: {{ date('d/m/Y') }}</p>
                </div>
            </div>
        </div>
        <div class="row bg-white">
            <div class="col-6 p-3">

                <h4>Order information</h4>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th width="150">Order date</th>
                            <td>{{ $order->created_at->format('F d, Y') }}</td>
                        </tr>
                        <tr>
                            <th width="150">Order status</th>
                            <td>{{ $order->status() }}</td>
                        </tr>
                        <tr>
                            <th width="150">Payment method</th>
                            <td>{{ $order->paymentMethod() }}</td>
                        </tr>
                        @if ($order->payment_method === 'razorpay' && $order->transaction()->exists())
                            <tr>
                                <th width="150">Transaction ID</th>
                                <td>{{ $order->transaction->transaction_id }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th width="150">Note</th>
                            <td>{{ $order->note }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-6 p-3">
                <h4>Address</h4>
                <div class="address">
                    <p class="mb-1">
                        <strong>{{ $order->address->full_name }}</strong>
                    </p>
                    <p>
                        {{ $order->address->phone }} <br>
                        {{ $order->address->address_line1 }} <br>
                        {{ $order->address->address_line2 }} <br>
                        {{ $order->address->city }}, {{ $order->address->district }},
                        {{ $order->address->state }}<br>
                        {{ $order->address->pincode }} <br>
                        {{ $order->address->landmark }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card table-responsive">
                    <div class="card-body">
                        <h4 class="card-title">Products</h4>
                        @include('components.admin.common.orderProducts', ['type' => 'admin', 'order' => $order])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
