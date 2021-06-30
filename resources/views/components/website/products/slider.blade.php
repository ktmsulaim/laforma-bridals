<div class="owl-carousel owl-theme prod_pics magnific-gallery">
    @if ($images && count($images))
        @foreach ($images as $image)
            <div class="item">
                <a href="{{ $image }}" data-effect="mfp-zoom-in"><img src="{{ $image }}" alt=""></a>
            </div>
        @endforeach
    @else    
        <!-- /item -->
        <div class="item">
            <img src="{{ asset('img/970x610.png') }}" data-src="{{ asset('img/970x610.png') }}" alt="" class="owl-lazy">
        </div>
        <!-- /item -->
    @endif
</div>
<!-- /carousel -->