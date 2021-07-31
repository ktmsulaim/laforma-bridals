<table class="table border">
    <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Unit price</th>
            <th>Quantity</th>
            <th>Line total</th>
        </tr>
    </thead>
    <tbody>
        @if ($order->products)
            @foreach ($order->products as $orderProduct)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ $type == 'admin' ? route('admin.products.edit', $orderProduct->product->id) : route('singleProduct', $orderProduct->product->slug) }}">{{ $orderProduct->product->name }}</a>

                        @if ($orderProduct->options()->exists())
                        <div class="product-options">
                            @php
                                $data = [];
                                foreach($orderProduct->options as $cartProductOption) {
                                    if($cartProductOption->option()->exists()) {
                                        $data[$cartProductOption->option->name] = $cartProductOption->optionValue->label;
                                    }
                                }
                            @endphp
                            <cart-item-options :data='@json($data)'></cart-item-options>
                        </div>
                        @endif
                    </td>
                    <td><strong>{{ App\Helpers\Money::format($orderProduct->unit_price) }}</strong></td>
                    <td>{{ $orderProduct->qty }}</td>
                    <td><strong>{{ App\Helpers\Money::format($orderProduct->line_total) }}</strong></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">No products!</td>
            </tr>
        @endif
    </tbody>
</table>

<div class="order-summary-wrapper">
    <div class="order-summary">
        <ul>
            <li>
                <span>Sub total</span>
                <strong>{{ App\Helpers\Money::format($order->sub_total) }}</strong>
            </li>
            <li>
                <span>Discount</span>
                <strong>{{ App\Helpers\Money::format($order->discount) }}</strong>
            </li>
            <li>
                <span>Shipping fee</span>
                <strong>{{ App\Helpers\Money::format($order->shipping_fee) }}</strong>
            </li>
        </ul>

        <div class="total">
            <span>Total</span>
            <span>{{ App\Helpers\Money::format($order->total) }}</span>
        </div>
    </div>
</div>