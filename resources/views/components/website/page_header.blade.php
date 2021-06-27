<div class="page_header">
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