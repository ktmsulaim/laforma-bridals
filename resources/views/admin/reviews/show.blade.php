@extends('layouts.admin.base', ['title' => 'Show review'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $review->title }}</h4>
                    <p>{{ $review->review }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Info</h4>
                    <div class="table-responsive">
                        <table class="table border">
                            <tr>
                                <th width="100">Posted on</th>
                                <td>{{ $review->created_at->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <th width="100">Modified</th>
                                <td>{{ !$review->created_at->eq($review->updated_at) ? $review->updated_at->diffForHumans() : 'Not yet' }}
                                </td>
                            </tr>
                            <tr>
                                <th width="100">Rating</th>
                                <td>{{ $review->rating }}
                                </td>
                            </tr>
                            <tr>
                                <th width="100">Status</th>
                                <td>
                                    <div class="d-flex justify-content-between align-center">
                                        <div class="status">
                                            @if ($review->status === 1)
                                                <span class="badge badge-xl badge-success">Published</span>
                                            @else
                                                <span class="badge badge-xl badge-warning">Draft</span>

                                            @endif
                                        </div>
                                        <div class="change-status">
                                            <form action="{{ route('admin.reviews.update', $review->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="status" value="{{ $review->status === 1 ? 0 : 1 }}">
                                                <button class="btn btn-sm btn-info"><i class="mdi mdi-refresh"></i> Change</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <h4 class="card-title">Customer</h4>
                    <div class="table-responsive">
                        <table class="table border">
                            <tr>
                                <th width="100">Name</th>
                                <td>
                                    @if ($review->customer)
                                        <a
                                            href="{{ route('admin.customers.show', $review->customer->id) }}">{{ $review->customer->name }}</a>
                                    @else
                                        {{ $review->reviewer_name }}
                                    @endif
                                </td>
                            </tr>
                            @if ($review->customer)
                                <tr>
                                    <th width="100">Phone</th>
                                    <td>{{ $review->customer->phone }}</td>
                                </tr>
                                <tr>
                                    <th width="100">Email</th>
                                    <td>{{ $review->customer->email }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <h4 class="card-title">Product</h4>
                    <div class="table-responsive">
                        <table class="table border">
                            <tr>
                                <th width="100">Name</th>
                                <td><a
                                        href="{{ route('admin.products.edit', $review->product->id) }}">{{ $review->product->name }}</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
