@component('mail::message')
# Hello {{ $order->customer->name }},

@component('mail::panel')
{{ $message }}
@endcomponent

@component('mail::button', ['url' => route('customer.orders.show', $order->id)])
    View order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent