<style>
    table {
        font-size: 14px;
    }

    table td {
        padding: 8px;
    }

    table td.key {
        width: 60%;
    }
</style>

@component('mail::message')
<h2 style="text-align: center">Order Placed</h2>
<p style="text-align: center">Order ID: #{{$order->id}}</p>

<div>
    <h4>Hello, {{ $order->customer->name }}</h4>
    <p style="font-size: 13px">Thank you for your order. We’ll send a confirmation when your order ships. If you would like to view the status of your order or make any changes to it, please visit Your Orders on La'forma bridals.</p>
</div>
<hr>
<h4>Order Summary</h4>
<table>
    <tr>
        <td class="key">Sub total</td>
        <td>{{ App\Helpers\Money::format($order->sub_total) }}</td>
    </tr>
    <tr>
        <td class="key">Shipping fee</td>
        <td>{{ App\Helpers\Money::format($order->shipping_fee) }}</td>
    </tr>
    <tr>
        <td class="key">Discount</td>
        <td>{{ App\Helpers\Money::format($order->discount) }}</td>
    </tr>
    <tr>
        <th class="key total">Total</th>
        <th>{{ App\Helpers\Money::format($order->total) }}</th>
    </tr>
</table>

@component('mail::button', ['url' => route('customer.orders.show', $order->id)])
    View order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent