<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ $title }} - La'forma Bridals</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="DESIGNERS MAKE OVER STUDIO" name="description" />
        <meta content="Salam Hudawi" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
         <!-- App favicon -->
         <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

         <!-- Bootstrap Css -->
         <link href="{{ asset('assets/app/css/bootstrap.min.css') }}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
         <!-- Icons Css -->
         <link href="{{ asset('assets/app/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
         <!-- App Css-->
         <link href="{{ asset('assets/app/css/app.min.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />
 
         <meta name="theme-color" content="#a21d23">

    </head>


    <body class="authentication-bg">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="text-center">
                            <a href="index.html" class="logo">
                                <img src="{{ asset('img/4.png') }}" alt="" height="100" class="logo-light mx-auto">
                               <img src="{{ asset('img/3.png') }}" alt="" height="100" class="logo-dark mx-auto">
                            </a>
                            <p class="text-muted mt-2 mb-4">DESIGNERS MAKE OVER STUDIO</p>
                        </div>

                        @yield('content')

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
    

        <!-- Vendor js -->
        <script src="{{ asset('assets/app/js/vendor.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/app/js/app.min.js') }}"></script>
        
    </body>
</html>