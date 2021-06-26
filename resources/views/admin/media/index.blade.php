@extends('layouts.admin.base', ['title' => 'Media'])

@push('libs_css')
    <link rel="stylesheet" href="{{ asset('assets/app/libs/magnific-popup/magnific-popup.css') }}">
@endpush
@push('libs_js')
    <script src="{{ asset('assets/app/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
@endpush
@section('content')
    <list-media></list-media>
@endsection