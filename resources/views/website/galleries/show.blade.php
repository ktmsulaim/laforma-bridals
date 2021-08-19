@extends('layouts.website.secondary', ['title' => $gallery->name . " | Collections"])

@push('css_libs')
    {{-- <link rel="stylesheet" href="{{ asset('assets/app/libs/magnific-popup/magnific-popup.css') }}"> --}}
@endpush

@push('js_libs')
    <script src="{{ asset('assets/app/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
@endpush

@push('meta')
    <meta name="title" content="{{ $gallery->name }}">
    <meta name="description" content="{{ $gallery->description }}">

    <meta property="og:title" content="{{ $gallery->name }}" />
    <meta property="og:description" content="{{ $gallery->description }}" />
    <meta property="og:image" content="{{ $gallery->baseImage() }}" />
@endpush

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => $gallery->name, 'links' => [
        [
            'url' => route('collections.index'),
            'label' => 'Collections'
        ],
        [
            'url' => route('collections.show', $gallery->slug),
            'label' => $gallery->name
        ],
    ]])
@endsection
@section('content')
    <single-collection :id="{{ $gallery->id }}"></single-collection>
@endsection
