@extends('layouts.admin.base', ['title' => 'Create product'])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <products-form></products-form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <errors></errors>
            @include('components.admin.common.errors')
        </div>
    </div>
@endsection
