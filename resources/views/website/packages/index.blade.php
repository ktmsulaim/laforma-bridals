@extends('layouts.website.secondary', ['title' => 'Packages'])

@section('content')
    @include('components.website.page_header', ['pageTitle' => "Packages", 'links' => [
    [
    'url' => route('packages.index'),
    'label' => 'Packages'
    ],
    ]])

<packages></packages>
@endsection