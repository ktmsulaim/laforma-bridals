@component('mail::message')
# Welcome {{ $customer->name }},

Thank you for being part of us. Please, have a glance on our products and packages. Hope you will be very excited to see the variety of new products. We are working harder to make all of them availabe at a reasonable price for you!

Thanks,<br>
{{ config('app.name') }}
@endcomponent