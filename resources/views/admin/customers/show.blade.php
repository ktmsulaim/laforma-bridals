@extends('layouts.admin.base', ['title' => "Show Customer"])

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="text-center card-box">
                <div>
                    <img src="{{ $customer->photo() }}" class="rounded-circle avatar-xl img-thumbnail mb-3" alt="profile-image">

                    <p class="text-muted font-13 mb-4">
                        
                    </p>

                    <div class="text-left">
                        <p class="text-muted font-13"><strong>Full Name :</strong> <span class="ml-2">{{ $customer->name }}</span></p>

                        <p class="text-muted font-13"><strong>Mobile :</strong><span class="ml-2">{{ $customer->phone }}</span></p>

                        <p class="text-muted font-13"><strong>Email :</strong> <span class="ml-2">{{ $customer->email }}</span> 
                            @if ($customer->email_verified_at)
                                <span class="text-success font-15" data-toggle="tooltip" data-title="Verified"><i class="mdi mdi-check-decagram"></i></span>
                            @endif
                        </p>

                        <p class="text-muted font-13 m-b-5"><strong>Username :</strong> <span class="ml-2"><span>@</span>{{ $customer->username }}</span></p>

                        @if ($customer->is_active)
                            <span class="badge badge-pill badge-success">Active</span>
                        @else
                            <span class="badge badge-pill badge-danger">Inactive</span>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection