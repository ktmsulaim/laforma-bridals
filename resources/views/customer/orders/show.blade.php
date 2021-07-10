@extends('layouts.customer.base', ['title' => 'Order #' . $order->id,'pageTitle' => 'Order #'. $order->id,
'pageSubTitle' => 'Order placed on ' . $order->created_at->format('F d, Y')])

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.customer.navigation')
        </div>
        <div class="col-md-9" id="show-order">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h4 class="heading">Order information</h4>
                    <div class="order-info">
                        <table class="table border">
                            <tr>
                                <th width="150">Email:</th>
                                <td>{{ $order->customer->email }}</td>
                            </tr>
                            <tr>
                                <th width="150">Date:</th>
                                <td>{{ $order->created_at->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <th width="150">Payment Method:</th>
                                <td>{{ $order->paymentMethod() }}</td>
                            </tr>
                            @if ($order->payment_method === 'razorpay' && $order->transaction()->exists())
                                <tr>
                                    <th>Transaction ID</th>
                                    <td>{{ $order->transaction->transaction_id }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Status</th>
                                <td>{{ Str::of($order->status)->title() }}</td>
                            </tr>
                            <tr>
                                <th width="150">Note:</th>
                                <td>{{ $order->note }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h4 class="heading">Address</h4>
                    <single-address :address='@json($order->address)' :readonly="true"></single-address>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col table-responsive">
                   @include('components.admin.common.orderProducts', ['type' => 'customer', 'order' => $order])
                </div>
            </div>
        </div>
    </div>
@endsection
