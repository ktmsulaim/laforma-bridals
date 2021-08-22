@extends('layouts.admin.base', ['title' => 'Edit page'])

@section('content')
    <page-form mode="edit" :page='@json($page)'></page-form>
@endsection