@extends('layouts.admin.base', ['title' => 'Print invoice - Booking #'. $booking->id])

@section('content')
    <div class="row">
        <div class="col text-right">
            <print-invoice source="booking-{{ $booking->id }}"
                :styles='@json([asset("assets/app/css/bootstrap.min.css"), asset("assets/app/css/icons.min.css"), asset('assets/app/css/admin.css')])'></print-invoice>
        </div>
    </div>
    <div class="card card-body" id="booking-{{ $booking->id }}">
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

                <h4>Booking information</h4>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th width="150">Booking date</th>
                            <td>{{ $booking->date() }}</td>
                        </tr>
                        <tr>
                            <th width="150">Booking time</th>
                            <td>{{ $booking->time }}</td>
                        </tr>
                        <tr>
                            <th width="150" style="vertical-align: middle">Status</th>
                            <td>
                                {{ $booking->status() }}
                            </td>
                        </tr>
                        <tr>
                            <th width="150" style="vertical-align: middle">Progress</th>
                            <td>
                                {{ $booking->progress() }}
                            </td>
                        </tr>
                        <tr>
                            <th width="150">Package</th>
                            <td>{{ $booking->package->name }}</td>
                        </tr>
                        <tr>
                            <th width="150">Booked on</th>
                            <td>{{ $booking->created_at->format('F d, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-6 p-3">
                <h4>Customer</h4>
                <div class="address">
                    <p class="mb-1">
                        <strong>{{ $booking->customer->name }}</strong>
                    </p>
                    <p>
                        {{ $booking->customer->phone }} <br>
                        {{ $booking->customer->email }} <br>
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card table-responsive">
                    <div class="card-body">
                        <h4 class="card-title">Services</h4>

                        <div class="table-responsive">
                            <table class="table border">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Total</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>{{ $booking->package->name }} - Booking charge</td>
                                    <td>{{ $booking->package->bookingPrice(true) }}</td>
                                    <td>{{ $booking->package->bookingPrice(true) }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>{{ $booking->package->name }} - Package amount</td>
                                    <td>{{ $booking->package->hasSpecialPrice() ? $booking->package->specialPrice() : $booking->package->price() }}</td>
                                    <td>{{ $booking->package->hasSpecialPrice() ? $booking->package->specialPrice() : $booking->package->price() }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="order-summary-wrapper">
                            <div class="order-summary">
                                <ul>
                                    <li>
                                        <span>Sub total</span>
                                        <strong>{{ $booking->subTotal() }}</strong>
                                    </li>
                                    <li>
                                        <span>Amount Paid</span>
                                        <strong>{{ $booking->amountPaid() }}</strong>
                                    </li>
                                </ul>
                        
                                <div class="total">
                                    <span>Total</span>
                                    <span>{{ $booking->total() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
