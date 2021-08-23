@extends('layouts.website.base', ['title' => 'Home'])

@section('content')
    
		<div id="carousel-home">
			<div class="owl-carousel owl-theme">
				@if ($slides && count($slides))
					@foreach ($slides as $slide)
						@include('components.website.slides.slide', 
						[
							'baseImage' => $slide->baseImage(), 
							'overlay' => $slide->overlay, 
							'actionButtonLink' => $slide->action_button_link, 
							'actionButtonText' => $slide->action_button_text, 
							'title' => $slide->title, 
							'subTitle' => $slide->sub_title, 
							'textAlign' => $slide->text_direction
						])
					@endforeach
				@else
					@include('components.website.slides.slide', ['baseImage' => null, 'overlay' => null, 'actionButtonLink' => null, 'actionButtonText' => null, 'title' => null, 'subTitle' => null, 'textAlign' => null])
				@endif
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

		@if ($featuredProduct && $featuredProduct['product'])		
		<div class="featured lazy" data-bg="url({{ $featuredProduct['image'] ? $featuredProduct['image']->path : asset('img/970x610.png') }})">
			<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
				<div class="container margin_60">
					<div class="row justify-content-center justify-content-md-start">
						<div class="col-lg-6 wow" data-wow-offset="150">
							<h3>{{ $featuredProduct['product']->name }}</h3>
							<p>{{ $featuredProduct['tag'] }}</p>
							<div class="feat_text_block">
								<div class="price_box">
									@if ($featuredProduct['product']->hasSpecialPrice())	
										<span class="new_price">{{ $featuredProduct['product']->specialPrice() }}</span>
										<span class="old_price">{{ $featuredProduct['product']->price() }}</span>
									@else
										<span class="new_price">{{ $featuredProduct['product']->price() }}</span>
									@endif
								</div>
								<a class="btn_1" href="{{ route('singleProduct', $featuredProduct['product']->slug) }}" role="button">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /featured -->
		@endif

		<div class="container margin_60_35">
			<div class="main_title">
				<h2>Packages</h2>
				<span>Pricing</span>
			</div>
			<packages></packages>
		</div>
		<!-- /container -->

		@if ($brands && count($brands))
		<div class="bg_gray">
			<div class="container margin_30">
				<div id="brands" class="owl-carousel owl-theme">
					@foreach ($brands as $brand)	
						<div class="item">
							<a href="javascript:void(0)">
								<img src="{{ $brand->path }}" data-src="{{ $brand->path }}" alt="" class="owl-lazy">
							</a>
						</div><!-- /item -->
					@endforeach
				</div><!-- /carousel -->
			</div><!-- /container -->
		</div>
		<!-- /bg_gray -->
		@endif
		

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