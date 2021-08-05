@extends('layouts.customer.base', ['title' => 'Booking #' . $booking->id,'pageTitle' => $booking->package->name,
'pageSubTitle' => $booking->summary()])

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.customer.navigation')
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="package-info">
                        <h4 class="title">Package</h4>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Package</strong>
                                <span>{{ $booking->package->name }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Features</strong>
                                <show-features :features='@json($booking->package->features)'></show-features>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Booking charge</strong>
                                <span>{{ $booking->package->bookingPrice(true) }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Package amount</strong>
                                <span>{{ $booking->package->price() }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="booking-info">
                        <h4 class="title">Booking</h4>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Date</strong>
                                <span>{{ $booking->date() }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Time</strong>
                                <span>{{ $booking->time }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Status</strong>
                                <span>{{ $booking->status() }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Progress</strong>
                                <span>{{ $booking->progress() }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="payment-info">
                        <h4 class="title">Payment</h4>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item heading">
                            Booking charge
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Payment</strong>
                                <span>{{ $booking->bookingCharge() ? $booking->bookingCharge()->status() : 'No' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Date</strong>
                                <span>{{ $booking->bookingCharge() ? $booking->bookingCharge()->created_at->format('d/m/Y') : null }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Transaction ID</strong>
                                <span>{{ $booking->bookingCharge() ? $booking->bookingCharge()->razorpay_payment_id : null }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row mt-2">
            @if (!$booking->isCancelled())    
                <div class="col d-flex">
                    <change-time :booking='@json($booking)'></change-time>
                    <cancel-booking :booking='@json($booking)'></cancel-booking>
                </div>
                @else
                    <div class="col">
                        <div class="alert alert-danger">
                            <p>
                                <strong>Oops!</strong> This appointment was cancelled by {{ $booking->cancelledBy() === 'customer' ? 'you' : 'Admin' }}
                            </p>
                            <small>{{ $booking->cancelledOn() }}</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection