@extends('layouts.website.secondary', ['title' => 'Sign up'])

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => 'Sign up', 'links' => [ ['label' => 'Sign up', 'url' => route('customer.register')] ]])
@endsection

@section('content')
    <auth type="register" :redirect="true"></auth>
@endsection
