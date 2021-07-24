@extends('layouts.customer.base', ['title' => 'Booking #' . $booking->id,'pageTitle' => 'Booking #'. $booking->id,
'pageSubTitle' => 'Booking summary: ' . $booking->summary()])

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.customer.navigation')
        </div>
        <div class="col-md-9">
            
        </div>
    </div>
@endsection