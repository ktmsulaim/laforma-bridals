@extends('layouts.website.secondary', ['title' => $package->name . ' | Packages'])

@push('meta')
    <meta name="title" content="{{ $package->name }}">
    <meta name="description" content="{{ $package->description }}">

    <meta property="og:title" content="{{ $package->name }}" />
    <meta property="og:description" content="{{ $package->description }}" />
    <meta property="og:image" content="{{ $package->baseImage() }}" />
@endpush

@section('content')
    @include('components.website.page_header', ['pageTitle' => $package->name, 'links' => [
    [
    'url' => route('packages.index'),
    'label' => 'Packages'
    ],
    [
    'url' => route('packages.show', $package->slug),
    'label' => $package->name
    ]
    ]])

    <div class="row">
        <div class="col-lg-6 col-md-6">
            @if ($package->images()->exists())
                <div class="all">
                    <div class="slider">
                        <div class="owl-carousel owl-theme main">
                            @foreach ($package->imagesForSlider() as $image)
                                <div style="background-image: url({{ $image }});" class="item-box"></div>
                            @endforeach
                        </div>
                        <div class="left nonl"><i class="ti-angle-left"></i></div>
                        <div class="right"><i class="ti-angle-right"></i></div>
                    </div>
                    <div class="slider-two">
                        <div class="owl-carousel owl-theme thumbs">
                            @foreach ($package->imagesForSlider() as $image)
                                <div style="background-image: url({{ $image }});"
                                    class="item {{ $loop->iteration === 1 ? 'active' : '' }}"></div>
                            @endforeach
                        </div>
                        <div class="left-t nonl-t"></div>
                        <div class="right-t"></div>
                    </div>
                </div>
            @else
                <img src="{{ $package->baseImage() }}" alt="Base image" class="img-fluid">
            @endif
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="description">
                {!! $package->description !!}
            </div>
            <div class="my-2">
                <show-features :features='@json($package->features)'></show-features>
            </div>
            <div>
                <book-package :package_id="{{ $package->id }}"></book-package>
            </div>
        </div>
    </div>
@endsection

@push('js_libs')
    <script>
        var changeSlide = 4; // mobile -1, desktop + 1
        // Resize and refresh page. slider-two slideBy bug remove
        var slide = changeSlide;
        if ($(window).width() < 600) {
            var slide = changeSlide;
            slide--;
        } else if ($(window).width() > 999) {
            var slide = changeSlide;
            slide++;
        } else {
            var slide = changeSlide;
        }
        $(document).ready(function() {
            $(".main").owlCarousel({
                nav: true,
                items: 1
            });
            $(".thumbs").owlCarousel({
                nav: true,
                margin: 15,
                mouseDrag: false,
                touchDrag: true,
                responsive: {
                    0: {
                        items: changeSlide - 1,
                        slideBy: changeSlide - 1
                    },
                    600: {
                        items: changeSlide,
                        slideBy: changeSlide
                    },
                    1000: {
                        items: changeSlide + 1,
                        slideBy: changeSlide + 1
                    }
                }
            });
            var owl = $(".main");
            owl.owlCarousel();
            owl.on("translated.owl.carousel", function(event) {
                $(".right").removeClass("nonr");
                $(".left").removeClass("nonl");
                if ($(".main .owl-next").is(".disabled")) {
                    $(".slider .right").addClass("nonr");
                }
                if ($(".main .owl-prev").is(".disabled")) {
                    $(".slider .left").addClass("nonl");
                }
                $(".slider-two .item").removeClass("active");
                var c = $(".slider .owl-item.active").index();
                $(".slider-two .item")
                    .eq(c)
                    .addClass("active");
                var d = Math.ceil((c + 1) / slide) - 1;
                $(".slider-two .owl-dots .owl-dot")
                    .eq(d)
                    .trigger("click");
            });
            $(".right").click(function() {
                $(".slider .owl-next").trigger("click");
            });
            $(".left").click(function() {
                $(".slider .owl-prev").trigger("click");
            });
            $(".slider-two .item").click(function() {
                var b = $(".item").index(this);
                $(".slider .owl-dots .owl-dot")
                    .eq(b)
                    .trigger("click");
                $(".slider-two .item").removeClass("active");
                $(this).addClass("active");
            });
            var owl2 = $(".thumbs");
            owl2.owlCarousel();
            owl2.on("translated.owl.carousel", function(event) {
                $(".right-t").removeClass("nonr-t");
                $(".left-t").removeClass("nonl-t");
                if ($(".two .owl-next").is(".disabled")) {
                    $(".slider-two .right-t").addClass("nonr-t");
                }
                if ($(".thumbs .owl-prev").is(".disabled")) {
                    $(".slider-two .left-t").addClass("nonl-t");
                }
            });
            $(".right-t").click(function() {
                $(".slider-two .owl-next").trigger("click");
            });
            $(".left-t").click(function() {
                $(".slider-two .owl-prev").trigger("click");
            });
        });
    </script>
@endpush
