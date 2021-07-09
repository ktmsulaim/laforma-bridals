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
                    <table class="table border">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Unit price</th>
                                <th>Quantity</th>
                                <th>Line total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($order->products)
                                @foreach ($order->products as $orderProduct)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('singleProduct', $orderProduct->product->slug) }}">{{ $orderProduct->product->name }}</a>

                                            @if ($orderProduct->options()->exists())
                                            <div class="product-options">
                                                @php
                                                    $data = [];
                                                    foreach($orderProduct->options as $cartProductOption) {
                                                        $data[$cartProductOption->option->name] = $cartProductOption->optionValue->label;
                                                    }
                                                @endphp
                                                <cart-item-options :data='@json($data)'></cart-item-options>
                                            </div>
                                            @endif
                                        </td>
                                        <td><strong>{{ App\Helpers\Money::format($orderProduct->unit_price) }}</strong></td>
                                        <td>{{ $orderProduct->qty }}</td>
                                        <td><strong>{{ App\Helpers\Money::format($orderProduct->line_total) }}</strong></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">No products!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="order-summary-wrapper">
                        <div class="order-summary">
                            <ul>
                                <li>
                                    <span>Sub total</span>
                                    <strong>{{ App\Helpers\Money::format($order->sub_total) }}</strong>
                                </li>
                                <li>
                                    <span>Discount</span>
                                    <strong>{{ App\Helpers\Money::format($order->discount) }}</strong>
                                </li>
                                <li>
                                    <span>Shipping fee</span>
                                    <strong>{{ App\Helpers\Money::format($order->shipping_fee) }}</strong>
                                </li>
                            </ul>
    
                            <div class="total">
                                <span>Total</span>
                                <span>{{ App\Helpers\Money::format($order->total) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
