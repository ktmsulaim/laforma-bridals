@extends('layouts.website.secondary', ['title' => $job->title])

@push('meta')
    <meta name="title" content="{{ $job->title }}">
    <meta name="description" content="{{ $job->summary() }}">

    <meta property="og:title" content="{{ $job->title }}" />
    <meta property="og:description" content="{{ $job->summary() }}" />
    <meta property="og:image" content="{{ $job->baseImage() }}" />
@endpush

@section('content_fluid')
    @include('components.website.page_header2', ['pageTitle' => $job->title, 'links' => [
            [
                'url' => route('jobs.index'),
                'label' => 'Jobs'
            ],
            [
                'url' => route('jobs.show', $job->slug),
                'label' => $job->title,
            ],
        ]
    ])
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-7 col-md-8 col-sm-12 mx-auto">
            <div class="job-single">
                <div class="job-poster">
                    <img src="{{ $job->baseImage() }}" alt="Poster" class="img-fluid">
                </div>
                <div class="job-data">
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
                            <li class="meta-list-item">
                                <i class="mdi mdi-calendar"></i>
                                <strong>Posted:</strong>
                                <span>{{ $job->created_at->format('F d, Y') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="job-description">
                        {!! $job->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection