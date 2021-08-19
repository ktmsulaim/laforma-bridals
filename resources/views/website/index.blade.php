@extends('layouts.website.base', ['title' => 'Home'])

@section('content')
    
		<div id="carousel-home">
			<div class="owl-carousel owl-theme">
				<div class="owl-slide cover" style="background-image: url(img/slides/slide_home_2.jpg);">
					<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
						<div class="container">
							<div class="row justify-content-center justify-content-md-end">
								<div class="col-lg-6 static">
									<div class="slide-text text-right white">
										<h2 class="owl-slide-animated owl-slide-title">Attack Air<br>Max 720 Sage Low</h2>
										<p class="owl-slide-animated owl-slide-subtitle">
											Limited items available at this price
										</p>
										<div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/owl-slide-->
				<div class="owl-slide cover" style="background-image: url(img/slides/slide_home_1.jpg);">
					<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
						<div class="container">
							<div class="row justify-content-center justify-content-md-start">
								<div class="col-lg-6 static">
									<div class="slide-text white">
										<h2 class="owl-slide-animated owl-slide-title">Attack Air<br>VaporMax Flyknit 3</h2>
										<p class="owl-slide-animated owl-slide-subtitle">
											Limited items available at this price
										</p>
										<div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/owl-slide-->
				<div class="owl-slide cover" style="background-image: url(img/slides/slide_home_3.jpg);">
					<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(255, 255, 255, 0.5)">
						<div class="container">
							<div class="row justify-content-center justify-content-md-start">
								<div class="col-lg-12 static">
									<div class="slide-text text-center black">
										<h2 class="owl-slide-animated owl-slide-title">Attack Air<br>Monarch IV SE</h2>
										<p class="owl-slide-animated owl-slide-subtitle">
											Lightweight cushioning and durable support with a Phylon midsole
										</p>
										<div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/owl-slide-->
				</div>
			</div>
			<div id="icon_drag_mobile"></div>
		</div>
		<!--/carousel-->

		<ul id="banners_grid" class="clearfix">
			<li>
				<a href="{{ route('products.index', ['category' => setting('ornaments_category', 'ornaments')]) }}" class="img_container">
					<img src="{{ asset('assets/website/img/ornaments.jpg') }}" data-src="{{ asset('assets/website/img/ornaments.jpg') }}" alt="" class="lazy">
					<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
						<h3>Ornaments</h3>
						<div><span class="btn_1">Shop Now</span></div>
					</div>
				</a>
			</li>
			<li>
				<a href="{{ route('products.index', ['category' => setting('garments_category', 'garments')]) }}" class="img_container">
					<img src="{{ asset('assets/website/img/garments.jpeg') }}" data-src="{{ asset('assets/website/img/garments.jpeg') }}" alt="" class="lazy">
					<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
						<h3>Garments</h3>
						<div><span class="btn_1">Shop Now</span></div>
					</div>
				</a>
			</li>
			<li>
				<a href="{{ route('products.index', ['category' => setting('jewells_category', 'jewells')]) }}" class="img_container">
					<img src="{{ asset('assets/website/img/jewells.jpg') }}" data-src="{{ asset('assets/website/img/jewells.jpg') }}" alt="" class="lazy">
					<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
						<h3>Jewells</h3>
						<div><span class="btn_1">View Products</span></div>
					</div>
				</a>
			</li>
		</ul>
		<!--/banners_grid -->
		
		<div class="container margin_60_35">
			<div class="main_title">
				<h2>Products</h2>
				<span>Featured</span>
			</div>
			<featured-products></featured-products>
			<!-- /row -->
		</div>
		<!-- /container -->

		<div class="featured lazy" data-bg="url(img/featured_home.jpg)">
			<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
				<div class="container margin_60">
					<div class="row justify-content-center justify-content-md-start">
						<div class="col-lg-6 wow" data-wow-offset="150">
							<h3>Armor<br>Air Color 720</h3>
							<p>Lightweight cushioning and durable support with a Phylon midsole</p>
							<div class="feat_text_block">
								<div class="price_box">
									<span class="new_price">$90.00</span>
									<span class="old_price">$170.00</span>
								</div>
								<a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /featured -->

		<div class="container margin_60_35">
			<div class="main_title">
				<h2>Packages</h2>
				<span>Pricing</span>
			</div>
			<packages></packages>
		</div>
		<!-- /container -->
		
		<div class="bg_gray">
			<div class="container margin_30">
				<div id="brands" class="owl-carousel owl-theme">
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_1.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_2.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_3.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_4.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_5.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_6.png" alt="" class="owl-lazy"></a>
					</div><!-- /item --> 
				</div><!-- /carousel -->
			</div><!-- /container -->
		</div>
		<!-- /bg_gray -->

		<div class="container margin_60_35">
			<div class="main_title">
				<h2>Latest collections</h2>
				<span>Gallery</span>
				{{-- <p>Cum doctus civibus efficiantur in imperdiet deterruisset</p> --}}
			</div>
			<latest-collection></latest-collection>
		</div>
		<!-- /container -->
@endsection