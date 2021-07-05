
	@include('components.website.header')
	<main class="bg_gray">
        <div class="container margin_90_65">
            <div class="main_title">
                <h1>{{ $pageTitle }}</h1>
                <p>{{ $pageSubTitle }}</p>
            </div>
            {{-- <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="search-input white">
                        <input type="text" placeholder="Search on account settings">
                        <button type="submit"><i class="ti-search"></i></button>
                    </div>
                    <!-- /search-input -->
                </div>
            </div> --}}
        </div>
        <!-- /container -->
        <div class="bg_white">
			<div class="container margin_90_65">
                @yield('content')
            </div>
        </div>
	</main>
	<!-- /main -->
	@include('components.website.footer')
		
