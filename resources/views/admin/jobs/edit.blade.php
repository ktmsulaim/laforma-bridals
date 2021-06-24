@extends('layouts.admin.base', ['title' => 'Edit ' . $job->title])

@section('content')
    <job-form mode="edit" :job="{{ $job }}">
        @include('components.admin.common.delete', ['item' => 'job', 'url' => route('admin.jobs.destroy', $job->id)])
    </job-form>
@endsection