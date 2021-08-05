@extends('layouts.admin.base', ['title' => 'Booking #'. $booking->id])

@section('content')
    <div class="row mb-3">
        <div class="col text-right">
            <a href="{{ route('admin.bookings.print', $booking->id) }}" class="btn btn-primary"><span class="mdi mdi-printer"></span> Print</a>
        </div>
    </div>

    @if ($booking->isCancelled())    
        <div class="row">
            <div class="col">
                <div class="alert alert-danger">
                    <strong>Oh snap!</strong> The booking was cancelled by <b>{{ $booking->cancelledBy() }}</b> {{ $booking->cancelledOn() }}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Booking info</h4>

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
                                    <booking-status :old-status='@json(['data' => $booking->status, 'text' => $booking->status()])' booking-id="{{ $booking->id }}"></booking-status>
                                </td>
                            </tr>
                            <tr>
                                <th width="150" style="vertical-align: middle">Progress</th>
                                <td>
                                    <booking-progress :old-progress='@json(['data' => $booking->progress, 'text' => $booking->progress()])' booking-id="{{ $booking->id }}"></booking-progress>
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
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Customer</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th width="180">Customer Name</th>
                                <td>{{ $booking->customer->name }}</td>
                            </tr>
                            <tr>
                                <th>Customer Email</th>
                                <td>{{ $booking->customer->email }}</td>
                            </tr>
                            <tr>
                                <th>Customer Phone</th>
                                <td>{{ $booking->customer->phone }}</td>
                            </tr>
                        </table>
                    </div>

                    <h4 class="card-title">Payment Info</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th width="180">Booking Charge</th>
                                <td>{{ $booking->package->bookingPrice(true) }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $booking->bookingCharge() && $booking->bookingCharge()->status === 'success' ? 'Paid on '. $booking->bookingCharge()->created_at->format('dS F, Y') : null}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection