@extends('layouts.website.secondary', ['title' => 'Reset Password'])

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => 'Reset Password', 'links' => [ ['label' => 'Reset Password', 'url' => route('customer.password.reset', ['token' => $token])] ]])
@endsection

@section('content')
    <reset-password token="{{ $token }}"></reset-password>
@endsection
