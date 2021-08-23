@extends('layouts.admin.base', ['title' => 'Dashboard'])

@section('content')
<div class="row">

    <div class="col-xl-3 col-md-6">
        @include('components.admin.dashboard.status_card_1', ['title' => 'Products', 'subTitle' => 'Upto date', 'count' => $products, 'icon' => 'view-list'])
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        @include('components.admin.dashboard.status_card_1', ['title' => 'Packages', 'subTitle' => 'Upto date', 'count' => $packages, 'icon' => 'package-variant-closed'])
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        @include('components.admin.dashboard.status_card_1', ['title' => 'Orders', 'subTitle' => 'This month', 'count' => $orders, 'icon' => 'currency-inr'])
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        @include('components.admin.dashboard.status_card_1', ['title' => 'Bookings', 'subTitle' => 'This month', 'count' => $bookings, 'icon' => 'calendar-month'])
    </div><!-- end col -->

</div>

<div class="row">
    @include('components.admin.dashboard.charts', ['orders' => $chart['orders'], 'bookings' => $chart['bookings']])
</div>
<div class="row">
    <div class="col-xl-4">
        <div class="card-box">

            <h4 class="header-title mb-3">New customers</h4>

            <div class="inbox-widget">
                @if ($customers && count($customers))
                    @foreach ($customers as $customer)    
                    <div class="inbox-item">
                        <a href="{{ route('admin.customers.show', $customer->id) }}">
                            <div class="inbox-item-img"><img src="{{ $customer->photo() }}" class="rounded-circle" alt=""></div>
                            <h5 class="inbox-item-author mt-0 mb-1">{{ $customer->name }}</h5>
                            <p class="inbox-item-text">{{ $customer->email }}</p>
                            <p class="inbox-item-date">{{ $customer->created_at->format(Carbon\Carbon::today() === $customer->created_at->day ? 'g:i A' : 'd/m/Y') }}</p>
                        </a>
                    </div>
                    @endforeach
                @else
                    <div class="inbox-item">
                        <p>No new customers</p>
                    </div>
                @endif
                
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-xl-8">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Latest Bookings</h4>

            <div class="table-responsive">
                @if ($latestBookings && count($latestBookings))    
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Package</th>
                            <th>Booking date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestBookings as $booking)    
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $booking->customer->name }}</td>
                                    <td>{{ $booking->package->name }}</td>
                                    <td>{{ $booking->date() }}</td>
                                    <td>{{ $booking->time }}</td>
                                    <td><span class="badge badge-success">Approved</span></td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}"><i class="mdi mdi-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p>No recent bookings found!</p>
                @endif
            </div>
        </div>
    </div><!-- end col -->

</div>
@endsection


@push('libs_js')
    <script src="{{ asset('assets/app/libs/jquery-knob/jquery.knob.min.js') }}"></script>
@endpush