@extends('layouts.website.secondary', ['title' => 'Sign up'])

@section('content')
    @include('components.website.page_header', ['pageTitle' => 'Sign up', 'links' => [ ['label' => 'Sign up', 'url' => route('customer.register')] ]])
    <auth type="register"></auth>
@endsection
