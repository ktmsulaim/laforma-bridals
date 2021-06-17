@extends('layouts.admin.base', ['title' => 'Edit ' . $product->name])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <products-form mode="edit" :product="{{$product}}"></products-form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <errors></errors>
            @include('components.admin.common.delete', ['item' => 'product', 'url' => route('admin.images.destroy', $product->id)])
        </div>
    </div>
@endsection
