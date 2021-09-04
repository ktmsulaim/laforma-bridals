@extends('layouts.website.secondary', ['title' => 'Sign in'])

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => 'Sign in', 'links' => [ ['label' => 'Sign in', 'url' => route('customer.login')] ]])
@endsection

@section('content')
    <auth type="login" :redirect="true"></auth>
@endsection
