@extends('layouts.customer.base', ['title' => 'Account','pageTitle' => 'Account', 'pageSubTitle' => 'Manage your account'])

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.customer.navigation')
        </div>
        <div class="col-md-5">
            <edit-profile :customer='@json($customer)'></edit-profile>
        </div>
        <div class="col-md-4">
            <upload-profile-picture old-photo="{{$customer->photo()}}"></upload-profile-picture>
            <div class="linked-social-accounts">
                <div class="social-panel">
                    <div class="social-icon">
                        <img src="{{ asset('img/search.png') }}" alt="Google ICON" width="60">
                    </div>
                    <div class="status">
                        @if ($customer->google_id)
                            <span class="text">Linked</span>
                            <span class="icon">
                                <i class="mdi mdi-check-circle"></i>
                            </span>
                        @else
                            <span class="text">Not linked</span>
                            <span class="icon">
                                <i class="mdi mdi-close-circle"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="social-panel">
                    <div class="social-icon">
                        <img src="{{ asset('img/facebook.png') }}" alt="Facebook ICON" width="60">
                    </div>
                    <div class="status">
                        @if ($customer->facebook_id)
                            <span class="text">Linked</span>
                            <span class="icon">
                                <i class="mdi mdi-check-circle"></i>
                            </span>
                        @else
                            <span class="text">Not linked</span>
                            <span class="icon">
                                <i class="mdi mdi-close-circle"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection