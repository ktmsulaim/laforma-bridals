<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ $title }} | Admin panel - La'forma Bridals</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="DESIGNERS MAKE OVER STUDIO" name="description" />
        <meta content="Salam Hudawi" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/app/css/bootstrap.min.css') }}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/app/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/app/css/app.min.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />
        
        <link href="{{ asset('assets/app/libs/toastr/toastr.min.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />
        
        <link href="{{ asset('assets/app/css/fonts.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/app/libs/custombox/custombox.min.css') }}" rel="stylesheet" />
        

        @stack('libs_css')
        
        <link href="{{ mix('assets/app/css/admin.css') }}" rel="stylesheet" type="text/css" />

        <meta name="theme-color" content="#a21d23">

        @routes

    </head>

    <body>

        <div id="app">
            <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <li class="d-none d-sm-block">
                        <form class="app-search">
                            <div class="app-search-box">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <div class="input-group-append">
                                        <button class="btn" type="submit">
                                            <i class="fe-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </li>
        
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle  waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="fe-bell noti-icon"></i>
                            <span class="badge badge-danger rounded-circle noti-icon-badge">9</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="m-0">
                                    <span class="float-right">
                                        <a href="" class="text-dark">
                                            <small>Clear All</small>
                                        </a>
                                    </span>Notification
                                </h5>
                            </div>

                            <div class="slimscroll noti-scroll">

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                    <div class="notify-icon">
                                        <img src="assets/images/users/user-1.jpg" class="img-fluid rounded-circle" alt="" /> </div>
                                    <p class="notify-details">Cristina Pride</p>
                                    <p class="text-muted mb-0 user-msg">
                                        <small>Hi, How are you? What about our next meeting</small>
                                    </p>
                                </a>
                            </div>

                            <!-- All-->
                            <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                View all
                                <i class="fi-arrow-right"></i>
                            </a>

                        </div>
                    </li>

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('img/user.svg') }}" alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ml-1">
                                {{ auth()->user()->name }} <i class="mdi mdi-chevron-down"></i> 
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-user"></i>
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-settings"></i>
                                <span>Settings</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a href="{{ route('admin.logout') }}" class="dropdown-item notify-item">
                                <i class="fe-log-out"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </li>

                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="{{ route('admin.index') }}" class="logo logo-dark text-center">
                        {{-- <span class="logo-lg">
                            <img src="{{ asset('img/4.png') }}" alt="" height="16">
                        </span>
                        <span class="logo-sm">
                            <img src="{{ asset('img/favicon.png') }}" alt="" height="24">
                        </span> --}}
                        <span class="styled"><span class="primary">La'</span>forma Bridals</span>
                    </a>
                    <a href="{{ route('admin.index') }}" class="logo logo-light text-center">
                        <span class="styled"><span class="primary">La'</span>forma Bridals</span>
                        {{-- <span class="logo-lg">
                            <img src="{{ asset('img/4.png') }}" alt="" height="16">
                        </span>
                        <span class="logo-sm">
                            <img src="{{ asset('img/favicon.png') }}" alt="" height="24">
                        </span> --}}
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
                    <li>
                        <button class="button-menu-mobile disable-btn waves-effect">
                            <i class="fe-menu"></i>
                        </button>
                    </li>

                    <li>
                        <h4 class="page-title-main">{{ $title }}</h4>
                    </li>
        
                </ul>

            </div>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="slimscroll-menu">

                    <!-- User box -->
                    <div class="user-box text-center">
                        <img src="{{ asset('img/user.svg') }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
                        <div class="dropdown">
                            <a href="javascript:void(0)" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-toggle="dropdown"  aria-expanded="false">{{ auth()->user()->name }}</a>
                        </div>
                        <p class="text-muted"><span>@</span>{{ auth()->user()->username }}</p>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="javascript:void(0)" class="text-muted">
                                    <i class="mdi mdi-cog"></i>
                                </a>
                            </li>

                            <li class="list-inline-item">
                                <a href="{{ route('admin.logout') }}">
                                    <i class="mdi mdi-power"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">

                            <li class="menu-title">Navigation</li>

                            <li>
                                <a href="{{ route('admin.index') }}" class="{{ Request::url() == route('admin.index') ? 'active' : '' }}">
                                    <i class="mdi mdi-view-dashboard"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.customers.index') }}">
                                    <i class="mdi mdi-account-multiple"></i>
                                    <span> Customers </span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="{{ Request::is('admin/products*') ? 'active' : '' }}">
                                    <i class="mdi mdi-view-list"></i>
                                    <span> Products </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="{{ route('admin.products.index') }}">Catalog</a></li>
                                    <li><a href="{{ route("admin.categories.index") }}">Categories</a></li>
                                    <li><a href="{{ route('admin.tags.index') }}">Tags</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="mdi mdi-currency-inr"></i>
                                    <span> Sales </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                                    <li><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('admin.packages.index') }}">
                                    <i class="mdi mdi-package-variant-closed"></i>
                                    <span> Packages </span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="mdi mdi-calendar-month"></i>
                                    <span> Bookings </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.jobs.index') }}">
                                    <i class="mdi mdi-card-account-details-outline"></i>
                                    <span> Jobs </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.media') }}">
                                    <i class="mdi mdi-file-image"></i>
                                    <span> Media </span>
                                </a>
                            </li>

                            <li class="menu-title">Website</li>

                            <li>
                                <a href="apps-chat.html">
                                    <i class="mdi mdi-folder-multiple-image"></i>
                                    <span> Sliders </span>
                                </a>
                            </li>
                            <li>
                                <a href="apps-chat.html">
                                    <i class="mdi mdi-camera"></i>
                                    <span> Gallery </span>
                                </a>
                            </li>
                            <li>
                                <a href="apps-chat.html">
                                    <i class="mdi mdi-email-outline"></i>
                                    <span> Contact responses </span>
                                </a>
                            </li>

                            <li class="menu-title">System</li>

                            <li>
                                <a href="apps-chat.html">
                                    <i class="mdi mdi-file-chart"></i>
                                    <span> Reports </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.settings.index') }}">
                                    <i class="mdi mdi-cog"></i>
                                    <span> Settings </span>
                                </a>
                            </li>


                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        @yield('content')
                        
                    </div> <!-- container-fluid -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                               {{ date('Y') }} &copy; La'forma Bridals | Developed by <a href="javascript:void(0)"> Artitudes</a> 
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">About Us</a>
                                    <a href="javascript:void(0);">Help</a>
                                    <a href="javascript:void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
        </div>
        <!-- Vendor js -->
        <script src="{{ asset('assets/app/js/vendor.min.js') }}"></script>
        
        <script src="{{ asset('assets/app/libs/toastr/toastr.min.js') }}"></script>
        
        <script src="{{ asset('assets/app/libs/custombox/custombox.min.js') }}"></script>

        <script src="{{ asset('assets/app/libs/ntc/ntc.js') }}"></script>
        
        <script src="{{ mix('assets/app/js/admin.js') }}"></script>

        @stack('libs_js')

        <!-- App js -->
        <script src="{{ asset('assets/app/js/app.min.js') }}"></script>


        <script>
            $(function(){
                $('.custom-control-input').on('change', function(){
                    let hiddenInput = $(this).prev()

                    if($(this).prop('checked') == true) {
                        hiddenInput.val('enable')
                    } else {
                        hiddenInput.val('disable')
                    }
                })
            })
        </script>

        {!! Toastr::message() !!}
        
    </body>
</html>