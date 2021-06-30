
	@include('components.website.header')
	<main class="bg_gray">
        <div class="container margin_30">
            @yield('content')
        </div>
		@yield('content_fluid')
	</main>
	<!-- /main -->
	@include('components.website.footer')
		
