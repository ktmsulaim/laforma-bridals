@extends('layouts.website.secondary', ['title' => 'Sign in'])

@section('content')
    @include('components.website.page_header', ['pageTitle' => 'Sign in', 'links' => [ ['label' => 'Sign in', 'url' => route('customer.login')] ]])
    <auth type="login" :redirect="true"></auth>
@endsection
