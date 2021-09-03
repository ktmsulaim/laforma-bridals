@extends('layouts.admin.base', ['title' => "Reports"])

@section('content')
    <div class="row">
        <div class="col-lg-9 col-md-9">
            <div class="card-box">
                <h4 class="header-title mt-0 mb-3">
                    @isset($type)
                        {{ $type }}
                    @endisset
                </h4>

                @isset($type)
                    @if ($data)
                    <table class="table">
                        <thead>
                            <tr>
                               @foreach ($columns as $column)
                                   <th>{{ $column }}</th>
                               @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                @if($type == 'Products Stock')
                                    <td><a href="{{ route('admin.products.edit', $item->id) }}">{{ $item->name }}</a></td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->in_stock ? 'In stock' : 'Out of stock' }}</td>
                                    <td>{{ $item->track_stock ? 'Yes' : 'No' }}</td>
                                @elseif ($type == 'Top Selling Products')    
                                    <td><a href="{{ route('admin.products.edit', $item->id) }}">{{ $item->name }}</a></td>
                                    <td>{{ $item->orders_count }}</td>
                                    <td>{{ $item->qty }}</td>
                                @elseif($type == 'Top Wishlisted Products')
                                    <td><a href="{{ route('admin.products.edit', $item->id) }}">{{ $item->name }}</a></td>
                                    <td>{{ $item->wishlist_count }}</td>
                                @elseif($type == 'Sales Report')
                                    <td>{{ $item['date'] }}</td>
                                    <td>{{ $item['orders'] }}</td>
                                    <td>{{ $item['products'] }}</td>
                                    <td>{{ $item['total'] ?: 0.00 }}</td>

                                @elseif($type == 'Bookings Report')
                                    <td>{{ $item['date'] }}</td>
                                    <td>{{ $item['bookings'] }}</td>
                                    <td>{{ $item['total'] ?: 0.00 }}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                        
                    @else
                        <p>No data found</p>
                    @endif
                @endisset
                @if ($data && $data->hasPages())
                    <div class="mt-3">
                        {{ $data->links() }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="card-box">
                <h4 class="header-title mt-0 mb-3">
                    Filters
                </h4>
                <form action="" method="get">
                    <filters-control></filters-control>
                </form>
            </div>
        </div>
    </div>
@endsection