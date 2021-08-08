<div class="top_banner bg" style="background-image: {{ @$bg ?: asset('img/banner.jpg') }}">
    <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.3)">
        <div class="container">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('website.index') }}">Home</a></li>
                    @if ($links && count($links))
                        @foreach ($links as $link)
                            @if (Request::url() === $link['url'])
                                <li>{{ $link['label'] }}</li>
                            @else
                                <li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
            <h1>{{ $pageTitle }}</h1>
        </div>
    </div>
    {{-- <img src="{{  }}" class="img-fluid" alt=""> --}}
</div>
<!-- /top_banner -->