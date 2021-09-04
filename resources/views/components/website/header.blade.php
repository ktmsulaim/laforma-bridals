<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Designers make over studio">
    <meta name="author" content="La'forma Bridals PVT LTD">
    <title>{{ $title }} | {{ setting('store_name', "La'forma Bridals") }} - {{ date('Y') }}</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    {{-- <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png"> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}" />
	
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="{{  asset('assets/website/css/bootstrap.custom.min.css') }}" rel="stylesheet">
    <link href="{{  asset('assets/website/css/style.css') }}" rel="stylesheet">
    
	{{-- Icons --}}
	<link href="{{  asset('assets/app/css/icons.min.css') }}" rel="stylesheet">

	<!-- SPECIFIC CSS -->
    <link href="{{  asset('assets/website/css/home_1.css') }}" rel="stylesheet">

	@stack('css_libs')

    <!-- YOUR CUSTOM CSS -->
    <link href="{{  asset('assets/website/css/website.css') }}" rel="stylesheet">

    <meta name="theme-color" content="#a21d23">

	<meta property="og:title" content="{{ $title }} | {{ setting('store_name', "La'forma Bridals") }} - {{ date('Y') }}" />
	<meta property="og:description" content="Designers make over studio" />
	<meta property="og:image" content="{{ asset('img/favicon.png') }}" />

	@stack('meta')

	@routes

	<script>
		window.Settings = Object.assign({}, @json(App\Models\Setting::serialize()))
	</script>

</head>

<body>	
	<div id="app">
		
	<header class="version_1">
		<div class="layer"></div><!-- Mobile menu overlay mask -->
		<div class="main_header">
			<div class="container">
				<div class="row small-gutters">
					<div class="col-xl-3 col-lg-3 d-lg-flex align-items-center">
						<div id="logo">
							<a href="{{ route('website.index') }}"><img src="{{ asset('img/logo_horizontal_white.svg') }}" alt=""></a>
						</div>
					</div>
					<nav class="col-xl-6 col-lg-7">
						<a class="open_close" href="javascript:void(0);">
							<div class="hamburger hamburger--spin">
								<div class="hamburger-box">
									<div class="hamburger-inner"></div>
								</div>
							</div>
						</a>
						<!-- Mobile menu button -->
						<div class="main-menu">
							<div id="header_menu">
								<a href="index.html"><img src="{{ asset('img/logo_horizontal_white.svg') }}" alt="" width="100" height="35"></a>
								<a href="#" class="open_close" id="close_in"><i class="ti-close"></i></a>
							</div>
							<ul>
								<li>
									<a href="{{ route("website.index") }}">Home</a>
								</li>
								<li>
									<a href="{{ route('products.index') }}">Products</a>
								</li>
								<li>
									<a href="{{ route('packages.index') }}">Packages</a>
								</li>
								<li>
									<a href="{{ route('jobs.index') }}">Jobs</a>
								</li>
								<li>
									<a href="{{ route('collections.index') }}">Collections</a>
								</li>
							</ul>
						</div>
						<!--/main-menu -->
					</nav>
					<div class="col-xl-3 col-lg-2 d-lg-flex align-items-center justify-content-end text-right">
						<a class="phone_top" href="tel:+919846374743"><strong><span>Need Help?</span>{{ setting('primary_contact_number', '+91 9846 374 743') }}</strong></a>
					</div>
				</div>
				<!-- /row -->
			</div>
		</div>
		<!-- /main_header -->

		<div class="main_nav Sticky">
			<div class="container">
				<div class="row small-gutters">
					<div class="col-xl-3 col-lg-3 col-md-3">
						<nav class="categories">
							<ul class="clearfix">
								<li><span>
										<a href="#">
											<span class="hamburger hamburger--spin">
												<span class="hamburger-box">
													<span class="hamburger-inner"></span>
												</span>
											</span>
											Categories
										</a>
									</span>
									@if ($categories && count($categories))	
										<div id="menu">
											<ul>
												@foreach ($categories as $category)
													<li><span><a href="{{ route('products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></span></li>
												@endforeach
											</ul>
										</div>
									@else
										<p>No category found!</p>
									@endif
								</li>
							</ul>
						</nav>
					</div>
					<div class="col-xl-6 col-lg-7 col-md-6 d-none d-md-block">
						<div class="custom-search-input">
							<form action="{{ route('products.index') }}" method="get">
								<input type="text" placeholder="Search over 10.000 products" name="search" value="{{ Request::get('search') }}">
								<button type="submit"><i class="header-icon_search_custom"></i></button>
							</form>
						</div>
					</div>
					<div class="col-xl-3 col-lg-2 col-md-3">
						<ul class="top_tools">
							<li>
								<cart></cart>
							</li>
							<li>
								<a href="{{ route('customer.wishlist') }}" class="wishlist"><span>Wishlist</span></a>
							</li>
							<li>
								<account-bar :user='@json(auth("customer")->user())'></account-bar>
							</li>
							<li>
								<a href="javascript:void(0);" class="btn_search_mob"><span>Search</span></a>
							</li>
							<li>
								<a href="#menu" class="btn_cat_mob">
									<div class="hamburger hamburger--spin" id="hamburger">
										<div class="hamburger-box">
											<div class="hamburger-inner"></div>
										</div>
									</div>
									Categories
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<div class="search_mob_wp">
				<form action="{{ route('products.index') }}" method="get">
					<input type="text" name="search" class="form-control" placeholder="Search over 10.000 products">
					<input type="submit" class="btn_1 full-width" value="Search">
				</form>
			</div>
			<!-- /search_mobile -->
		</div>
		<!-- /main_nav -->
	</header>
	<!-- /header -->