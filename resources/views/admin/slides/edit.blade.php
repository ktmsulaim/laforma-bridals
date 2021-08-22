@extends('layouts.admin.base', ['title' => 'Edit slide'])

@section('content')
    <slide-form mode="edit" :slide='@json($slide)'></slide-form>
@endsection