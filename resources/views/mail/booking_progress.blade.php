<style>
    table#package-info {
        font-size: 14px;
        color: #444; 
        margin-top: 15px;
        border: 1px solid #e1e1e1;
        margin-right: 0;
        width: 100%;
    }

    table#package-info tr th {
        font-weight: 600;
        text-align: left;
    }
    
    table#package-info tr td, table#package-info tr th {
        padding: 10px;
        vertical-align: middle;
        border-top: 1px solid #e1e1e1;
    }

    table#package-info tr:first-child td,
    table#package-info tr:first-child th {
        border-top: none;
    }

</style>

@component('mail::message')
# Hello {{ $booking->customer->name }},

@component('mail::panel')
{{ $message }}
@endcomponent

<table id="package-info">
    <tr>
        <th width="25%">Package</th>
        <td width="75%">{{ $booking->package->name }}</td>
    </tr>
    <tr>
        <th>Booked Date</th>
        <td>{{ $booking->date() }}</td>
    </tr>
    <tr>
        <th>Booked Time</th>
        <td>{{ $booking->time }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>{{ $booking->status() }}</td>
    </tr>
    <tr>
        <th>Booked On</th>
        <td>{{ $booking->created_at->format('d F, Y') }}</td>
    </tr>
</table>

@component('mail::button', ['url' => route('customer.bookings.show', $booking->id)])
    View details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent