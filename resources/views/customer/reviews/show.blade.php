@extends('layouts.customer.base', ['title' => 'Show review','pageTitle' => 'Show review', 'pageSubTitle' => $review->title])

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.customer.navigation')
        </div>
        <div class="col-md-9">
            <h4 class="title">{{ $review->title }}</h4>
            <div class="meta">
                <ul class="meta-list">
                    <li>
                        <i class="mdi mdi-clock"></i>
                        <b>Posted:</b>
                        <span>{{ $review->created_at->format('F d, Y') }}</span>
                    </li>
                    <li>
                        <i class="mdi mdi-calendar-outline"></i>
                        <b>Modifed:</b>
                        <span>{{ !$review->created_at->eq($review->updated_at) ? $review->updated_at->diffForHumans() : 'Not yet' }}</span>
                    </li>
                    <li>
                        <i class="mdi mdi-circle"></i>
                        <b>Status:</b>
                        <span>{{ $review->status === 1 ? 'Published' : 'Draft' }}</span>
                    </li>
                    <li>
                        <i class="mdi mdi-star"></i>
                        <b>Rating:</b>
                        <span>{{ $review->rating }}</span>
                    </li>
                </ul>
            </div>
            <p>{{ $review->review }}</p>
            <div class="review-actions">
                <review-actions :review='@json($review)'></review-actions>
            </div>
            <div class="mt-2">
                <product-vertical :product='@json(new App\Http\Resources\ProductResource($review->product))'></product-vertical>
            </div>
        </div>
    </div>
@endsection