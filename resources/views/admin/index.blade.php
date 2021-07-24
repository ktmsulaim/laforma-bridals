@extends('layouts.admin.base', ['title' => 'Dashboard'])

@section('content')
<div class="row">

    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-4">Total products</h4>

            <div class="widget-chart-1">
                <div class="widget-chart-box-1 float-left" dir="ltr">
                    <div style="display:inline;width:80px;height:80px;"><input data-plugin="knob" data-width="80" data-height="80" data-fgcolor="#f05050 " data-bgcolor="#F9B9B9" value="58" data-skin="tron" data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly" style="width: 44px; height: 26px; position: absolute; vertical-align: middle; margin-top: 26px; margin-left: -62px; border: 0px; background: none; font: bold 16px Arial; text-align: center; color: rgb(240, 80, 80); padding: 0px; appearance: none;"></div>
                </div>

                <div class="widget-detail-1 text-right">
                    <h2 class="font-weight-normal pt-2 mb-1"> 80 </h2>
                    <p class="text-muted mb-1">New in this month</p>
                </div>
            </div>
        </div>

    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card-box">

            <h4 class="header-title mt-0 mb-3">Orders Analytics</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">
                    <span class="badge badge-success badge-pill float-left mt-3">32% <i class="mdi mdi-trending-up"></i> </span>
                    <h2 class="font-weight-normal mb-1"> ₹8451 </h2>
                    <p class="text-muted mb-3">Revenue today</p>
                </div>
                <div class="progress progress-bar-alt-success progress-sm">
                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 77%;">
                        <span class="sr-only">77% Complete</span>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card-box">

            <h4 class="header-title mt-0 mb-4">Total Packages</h4>

            <div class="widget-chart-1">
                <div class="widget-chart-box-1 float-left" dir="ltr">
                    <div style="display:inline;width:80px;height:80px;"><input data-plugin="knob" data-width="80" data-height="80" data-fgcolor="#ffbd4a" data-bgcolor="#FFE6BA" value="15" data-skin="tron" data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly" style="width: 44px; height: 26px; position: absolute; vertical-align: middle; margin-top: 26px; margin-left: -62px; border: 0px; background: none; font: bold 16px Arial; text-align: center; color: rgb(255, 189, 74); padding: 0px; appearance: none;"></div>
                </div>
                <div class="widget-detail-1 text-right">
                    <h2 class="font-weight-normal pt-2 mb-1"> 5 </h2>
                    <p class="text-muted mb-1">New in this month</p>
                </div>
            </div>
        </div>

    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
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

            <h4 class="header-title mt-0 mb-3">Total bookings</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">
                    <span class="badge badge-pink badge-pill float-left mt-3">32% <i class="mdi mdi-trending-up"></i> </span>
                    <h2 class="font-weight-normal mb-1"> 25 </h2>
                    <p class="text-muted mb-3">Completed</p>
                </div>
                <div class="progress progress-bar-alt-pink progress-sm">
                    <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 77%;">
                        <span class="sr-only">77% Complete</span>
                    </div>
                </div>
            </div>
        </div>

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
                @if ($bookings && count($bookings))    
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
                            @foreach ($bookings as $booking)    
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