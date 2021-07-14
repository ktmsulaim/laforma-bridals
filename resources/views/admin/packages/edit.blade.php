@extends('layouts.admin.base', ['title' => 'Edit ' . $package->name])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <packages-form mode="edit" :packages="{{ $package }}"></packages-form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <errors></errors>
            @include('components.admin.common.delete', ['item' => 'package', 'url' => route('admin.packages.destroy', ['package' => $package->id])])
        </div>
    </div>
@endsection
