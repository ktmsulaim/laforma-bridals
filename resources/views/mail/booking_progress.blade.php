@component('mail::message')
# Hello {{ $booking->customer->name }},

@component('mail::panel')
{{ $message }}
@endcomponent

@component('mail::button', ['url' => route('customer.bookings.show', $booking->id)])
    View details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent