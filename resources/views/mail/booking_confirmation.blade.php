@component('mail::message')
<h2 style="text-align: center">Booking confirmation</h2>
<p style="text-align: center">Package: {{ $booking->package->name }}</p>

<div>
    <h4>Hello, {{ $booking->customer->name }}</h4>
    <p style="font-size: 13px">Thank you for your booking. This is to confirm that you have successfully booked an appointment for <b>{{ $booking->package->name }} at {{ $booking->time }} on {{ $booking->date('F d, Y') }}</b>. Please make sure the date and time is correct and appear the studio early. If you face any inconvenience on the booked date or time, feel free to change it to your covenience according to the availability. Remember there is no additional charges to change booked date and time</p>
</div>
    
Thanks,<br>
{{ config('app.name') }}
@endcomponent
