@extends('layouts.admin.base', ['title' => 'Order #'. $order->id])

@section('content')
    <div class="row mb-3">
        <div class="col text-right">
            <a href="{{ route('admin.orders.print', $order->id) }}" class="btn btn-primary"><span class="mdi mdi-printer"></span> Print</a>
        </div>
    </div>
    <div id="order-{{ $order->id }}">
        <div class="row" id="order-meta">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                       <h4 class="card-title">Order information</h4>
                       <div class="table-responsive">
                           <table class="table">
                               <tr>
                                   <th width="150">Order date</th>
                                   <td>{{ $order->created_at->format('F d, Y') }}</td>
                               </tr>
                               <tr>
                                   <th width="150" style="vertical-align: middle">Order status</th>
                                   <td>
                                       <order-status :old-status='@json(['data' => $order->status, 'text' => $order->status()])' order-id="{{ $order->id }}"></order-status>
                                   </td>
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
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                       <h4 class="card-title">Account information</h4>
                       <div class="table-responsive">
                           <table class="table">
                               <tr>
                                   <th>Customer name</th>
                                   <td>{{ $order->customer->name }}</td>
                               </tr>
                               <tr>
                                   <th>Customer phone</th>
                                   <td>{{ $order->customer->phone }}</td>
                               </tr>
                               <tr>
                                   <th>Customer email</th>
                                   <td>{{ $order->customer->email }}</td>
                               </tr>
                           </table>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Address</h4>
                        <div class="address">
                            <p class="mb-1">
                                <strong>{{ $order->address->full_name }}</strong>
                            </p>
                            <p>
                                {{ $order->address->phone }} <br>
                                {{ $order->address->address_line1 }} <br>
                                {{ $order->address->address_line2 }} <br>
                                {{ $order->address->city }}, {{ $order->address->district }}, {{ $order->address->state }}<br>
                                {{ $order->address->pincode }} <br>
                                {{ $order->address->landmark }}
                            </p>
                            
                        </div>
                    </div>
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