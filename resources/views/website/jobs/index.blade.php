@extends('layouts.website.secondary', ['title' => "Jobs"])

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => "Jobs", 'links' => [
        [
            'url' => route('jobs.index'),
            'label' => 'Jobs'
        ],
    ]])
@endsection
@section('content')
    <div class="row">
        @if ($jobs && $jobs->count())
            <div class="col-lg-7 col-md-8 col-sm-12 mx-auto">
                @foreach ($jobs as $job)
                    <div class="job">
                        <div class="job-poster">
                            <img src="{{ $job->baseImage() }}" alt="Poster">
                        </div>
                        <div class="job-data">
                            <div class="job-title">
                                <h4>{{ $job->title }}</h4>
                            </div>
                            <div class="job-description-summary">
                                <p>{{ $job->summary() }}</p>
                            </div>
                            <div class="meta-info">
                                <ul class="meta-list">
                                    <li class="meta-list-item">
                                        <i class="mdi mdi-account-tie"></i>
                                        <strong>For:</strong>
                                        <span>{{ ucfirst($job->for )}}</span>
                                    </li>
                                    <li class="meta-list-item">
                                        <i class="mdi mdi-clock"></i>
                                        <strong>Type:</strong>
                                        <span>{{ $job->type() }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="read-more">
                                <a href="{{ route('jobs.show', $job->slug) }}">Read more <i class="mdi mdi-arrow-right"></i></a>
                                <small>{{ $job->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="col">
                @include('components.website.no_data', ['type' => 'jobs', 'size' => 200])
            </div>
        @endif
    </div>
@endsection