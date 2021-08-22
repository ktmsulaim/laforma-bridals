<div class="owl-slide cover" style="background-image: url(@isset($baseImage) {{$baseImage ?: asset('img/970x610.png') }} @endisset);">
    <div class="opacity-mask d-flex align-items-center"  @isset($overlay) {!! $overlay === 'light' ? 'data-opacity-mask="rgba(255, 255, 255, 0.5)"' : 'data-opacity-mask="rgba(0, 0, 0, 0.5)"' !!} @endisset>
        <div class="container">
            <div class="row justify-content-center justify-content-md-{{ @$textAlign === 'right' ? 'end' : 'start' }}">
                <div class="col-lg-6 static">
                    <div class="slide-text @isset($textAlign) text-{{$textAlign ?: 'left'}} @endisset @isset($overlay) {{ $overlay === 'light' ? 'black' : 'white' }} @endisset">
                        @isset($title)
                            <h2 class="owl-slide-animated owl-slide-title">{{ $title ?? null }}</h2>
                        @endisset

                        @isset ($subTitle)
                            <p class="owl-slide-animated owl-slide-subtitle">
                                {{ $subTitle }}
                            </p>
                        @endisset
                        @isset($actionButtonText)
                            <div class="owl-slide-animated owl-slide-cta">
                                @isset($actionButtonText)
                                    <a class="btn_1" href="{{ @$actionButtonLink ?: 'javascript:void(0)' }}" role="button">{{ $actionButtonText }}</a>
                                @endisset
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>