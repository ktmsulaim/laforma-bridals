@extends('layouts.admin.base', ['title' => 'Edit gallery'])

@section('content')
    <gallery-form mode="edit" :gallery='@json($gallery)'></gallery-form>
@endsection