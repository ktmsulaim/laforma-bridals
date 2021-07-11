@extends('layouts.admin.base', ['title' => 'Transactions'])

@section('content')
    <div class="row mt-2">
        <div class="col-md-12">
            <list-transactions></list-transactions>
        </div>
    </div>
@endsection