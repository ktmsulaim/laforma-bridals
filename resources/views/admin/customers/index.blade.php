@extends('layouts.admin.base', ['title' => 'Customers'])

@section('content')
    <div class="row">
        <div class="col-12">
            <list-customers></list-customers>
        </div>
    </div>
@endsection