@extends('layouts.website.secondary', ['title' => $page->title])

@push('meta')
    <meta name="title" content="{{ $page->title }}">
    <meta name="description" content="{{ $page->summary() }}">

    <meta property="og:title" content="{{ $page->title }}" />
    <meta property="og:description" content="{{ $page->summary() }}" />
@endpush

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => $page->title, 'links' => [
        [
            'url' => route('page.show', ['slug' => $page->slug]),
            'label' => $page->title
        ],
    ]])
@endsection

@section('content')
    <div class="row justify-content-{{ $page->layout['align'] }}">
        <div class="col-lg-{{ $page->layout['column_size'] }} col-md-{{ $page->layout['column_size'] }}">
            <div class="card">
                <div class="card-body">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection