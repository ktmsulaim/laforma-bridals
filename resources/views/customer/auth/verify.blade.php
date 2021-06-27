@extends('layouts.website.secondary', ['title' => 'Verify email address'])

@section('content')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="box_account">
                <div class="form_container">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    
                    <h4>Email verification</h4>
                    <p>Before proceeding, please check your email <b>({{ auth('customer')->user()->email }})</b> for a verification link. If you did not receive the email request for verification link again. If you couldn't find the email in your inbox kindly check your spam folder also.</p>
                    <form class="d-block mt-3" method="POST" action="{{ route('customer.verification.resend') }}">
                        @csrf
                        <button type="submit"
                            class="btn_1 full-width">Request verification link</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
