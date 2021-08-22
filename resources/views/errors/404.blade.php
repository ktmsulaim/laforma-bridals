@extends('layouts.website.secondary', ['title' => "Page not found!"])

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => "Page not found!", 'links' => [
        [
            'url' => 'javascript:void(0)',
            'label' => "Page not found!"
        ],
    ]])
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ asset('img/error.png') }}" alt="Error" width="150">
                    <h3 class="mt-3">Sorry! The page you are looking for is not found!</h3>
                </div>
            </div>
        </div>
    </div>
@endsection