@extends('layouts.website.secondary', ['title' => "Collections"])

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => "Collections", 'links' => [
        [
            'url' => route('collections.index'),
            'label' => 'Collections'
        ],
    ]])
@endsection
@section('content')
    <collections></collections>
@endsection