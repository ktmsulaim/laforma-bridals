@extends('layouts.admin.base', ['title' => 'Edit ' . $service->name])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <services-form mode="edit" :service="{{ $service }}"></services-form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <errors></errors>
            @include('components.admin.common.delete', ['item' => 'service', 'url' => route('admin.services.destroy', ['service' => $service->id])])
        </div>
    </div>
@endsection
