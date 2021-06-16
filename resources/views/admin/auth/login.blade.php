@extends('layouts.admin.auth', ['title' => 'Login'])

@section('content')
<div class="card">

    <div class="card-body p-4">
        
        <div class="text-center mb-4">
            <h4 class="text-uppercase mt-0">Login</h4>
        </div>

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="username">Username</label>
                <input class="form-control @error('username') is-invalid @enderror" name="username" type="text" id="username" required value="{{ old('username') }}" placeholder="Enter your username">

                @error('username')
                    <p class="text-danger small mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" required id="password" placeholder="Enter your password">

                @error('password')
                    <p class="text-danger small mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkbox-signin" name="remember" checked>
                    <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                </div>
            </div>

            <div class="form-group mb-0 text-center">
                <button class="btn btn-primary btn-block" type="submit"> Log In </button>
            </div>

        </form>

    </div> <!-- end card-body -->
</div>
<!-- end card -->

<div class="row mt-3">
    <div class="col-12 text-center">
        <p> <a href="" class="text-dark ml-1"><i class="fa fa-lock mr-1"></i>Forgot your password?</a></p>
    </div> <!-- end col -->
</div>
<!-- end row -->
@endsection
