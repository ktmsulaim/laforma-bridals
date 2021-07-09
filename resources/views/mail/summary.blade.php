@component('mail::message')
# Welcome {{ $customer->name }},



Thanks,<br>
{{ config('app.name') }}
@endcomponent