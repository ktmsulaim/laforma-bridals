@extends('layouts.admin.base', ['title' => 'Create new service'])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <services-form mode="create"></services-form>
        </div>
        <div class="col-md-4">
            <errors></errors>
        </div>
    </div>
@endsection