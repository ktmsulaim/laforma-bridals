@extends('layouts.admin.base', ['title' => 'Create new package'])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <packages-form mode="create"></packages-form>
        </div>
        <div class="col-md-4">
            <errors></errors>
        </div>
    </div>
@endsection