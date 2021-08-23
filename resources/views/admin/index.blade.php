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
    <div class="col-xl-4">
        <div class="card-box">
            <div class="dropdown float-right">
                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                </div>
            </div>

            <h4 class="header-title mb-3">New customers</h4>

            <div class="inbox-widget">
                
                <div class="inbox-item">
                    <a href="#">
                        <div class="inbox-item-img"><card type="image"/></div>
                        <h5 class="inbox-item-author mt-0 mb-1"><card type="title" /></h5>
                        <p class="inbox-item-text"><card type="subtitle" /></p>
                        <p class="inbox-item-date">13:40 PM</p>
                    </a>
                </div>
                
                <div class="inbox-item">
                    <a href="#">
                        <div class="inbox-item-img"><card type="image"/></div>
                        <h5 class="inbox-item-author mt-0 mb-1"><card type="title" /></h5>
                        <p class="inbox-item-text"><card type="subtitle" /></p>
                        <p class="inbox-item-date">13:34 PM</p>
                    </a>
                </div>

                <div class="inbox-item">
                        <a href="#">
                        <div class="inbox-item-img"><card type="image"/></div>
                        <h5 class="inbox-item-author mt-0 mb-1"><card type="title" /></h5>
                        <p class="inbox-item-text"><card type="subtitle" /></p>
                        <p class="inbox-item-date">13:17 PM</p>
                    </a>
                </div>

                <div class="inbox-item">
                    <a href="#">
                        <div class="inbox-item-img"><card type="image"/></div>
                        <h5 class="inbox-item-author mt-0 mb-1"><card type="title" /></h5>
                        <p class="inbox-item-text"><card type="subtitle" /></p>
                        <p class="inbox-item-date">12:20 PM</p>
                    </a>
                </div>

                <div class="inbox-item">
                    <a href="#">
                        <div class="inbox-item-img"><card type="image"/></div>
                        <h5 class="inbox-item-author mt-0 mb-1"><card type="title" /></h5>
                        <p class="inbox-item-text"><card type="subtitle" /></p>
                        <p class="inbox-item-date">10:15 AM</p>
                    </a>
                </div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-xl-8">
        <div class="card-box">
            <div class="dropdown float-right">
                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                </div>
            </div>

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
                                    <td><i class="mdi mdi-eye"></i></td>
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