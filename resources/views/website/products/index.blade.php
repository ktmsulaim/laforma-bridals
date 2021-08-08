@extends('layouts.website.secondary', ['title' => "Products"])

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => "Products", 'links' => [
        [
            'url' => route('products.index'),
            'label' => 'Products'
        ],
    ]])
    <products-tool-box></products-tool-box>
@endsection

@section('content')
    <products-index :categories='@json($categories)' :tags='@json($tags)' :query='@json($query)' :max-price={{$maxPrice}}></products-index>
@endsection

@push('js_libs')
    <script src="{{ asset('assets/website/js/sticky_sidebar.min.js') }}"></script>
@endpush