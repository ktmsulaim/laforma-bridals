	@include('components.website.header')
	<main class="bg_gray">
		@yield('content_fluid')
        <div class="container margin_30">
            @yield('content')
        </div>
	</main>
	<!-- /main -->
	@include('components.website.footer')
		
