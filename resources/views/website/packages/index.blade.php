@extends('layouts.website.secondary', ['title' => 'Packages'])

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => "Packages", 'links' => [
        [
            'url' => route('packages.index'),
            'label' => 'Packages'
        ],
    ]])
    
@endsection
@section('content')
    <packages></packages>
@endsection