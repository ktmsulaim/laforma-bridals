@extends('layouts.website.secondary', ['title' => 'Inactive'])

@section('content')
    @include('components.website.page_header', ['pageTitle' => 'Inactive', 'links' => [ ['label' => 'Inactive', 'url' => route('customer.inactive')] ]])
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="box_account">
                <div class="form_container">
                    <h4>Account inactive</h4>
                    <p>Sorry! your account was inactive. Make sure you have verified your email. If you face this issue again please contact our website administrator for the further information</p>
                </div>
            </div>
        </div>
    </div>
@endsection