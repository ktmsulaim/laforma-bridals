<?php

namespace App\Http\Controllers;

use App\Events\NewOrderPlaced;
use App\Http\Resources\OrderResource;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function placeorder(Request $request)
    {
        $paymentMethod = $request->get('payment_method');
        
        if(!$paymentMethod) {
            return response()->json(['error' => 'Select a payment method to continue'], 422);
        }

        $request->validate([
            'customer_id' => 'required',
            'address_id' => 'required',
            'sub_total' => 'required|numeric',
            'shipping_fee' => 'numeric',
            'discount' => 'numeric',
            'total' => 'required|numeric',
            'payment_method' => 'required|string',
            'products' => 'required'
        ]);

        $order = $request->user('customer')->orders()->create([
            'address_id' => $request->get('address_id'),
            'sub_total' => $request->get('sub_total'),
            'shipping_fee' => $request->get('shipping_fee'),
            'discount' => $request->get('discount'),
            'total' => $request->get('total'),
            'payment_method' => $paymentMethod,
            'status' => $request->get('status'),
            'note' => $request->get('note')
        ]);

        if(!$request->has('products') || empty($request->get('products'))) {
            $order->delete();
            return response()->json(['error' => 'Add products to your cart to place order.'], 422);
        }

        $cartItems = $request->get('products');

        if(is_array($cartItems) && count($cartItems)) {
            foreach($cartItems as $cartItem) {
                $product = Product::findOrFail($cartItem['product_id']);
                $quantity = $cartItem['quantity'];

                // check whether product is orderable and in stock
                if(!$product->is_orderable || !$product->category->is_orderable || !$product->in_stock) {
                    $order->delete();
                    return response()->json(['error' => 'This product can\'t be ordered right now'], 422);
                } 
                
                $orderProduct = $order->products()->create([
                    'product_id' => $product->id,
                    'unit_price' => $cartItem['special_price'] ?: $cartItem['net_price'],
                    'qty' => $cartItem['quantity'],
                    'line_total' => $cartItem['special_price'] ? ($cartItem['special_price'] * $cartItem['quantity']) : ($cartItem['net_price'] * $cartItem['quantity']),
                ]);

                // Save product options
                if($cartItem['options'] && 
                !empty($cartItem['options']) && 
                is_array($cartItem['options']) &&
                count($cartItem['options'])) {
                    foreach($cartItem['options'] as $key => $cartItemOption) {
                        $option = $product->options()->where('name', $key)->first();
                        $optionValue = $option->values()->where('label', $cartItemOption)->first();

                        if(!$optionValue->in_stock) {
                            $order->delete();
                            return response()->json(['error' => "{$optionValue->label} in {$option->name} isn't available right now"], 422);
                        }

                        $orderProduct->options()->create([
                            'option_id' => $option->id,
                            'option_value_id' => $optionValue->id,
                        ]);
                    }
                }

                // Subtract product quantity on successful order
                if($product->track_stock) {
                    if($quantity > $product->qty) {
                        $order->delete();
                        return response()->json(['error' => 'Quantity must not exceed the maximum limit'], 422);
                    }

                    $this->updateProductQuantity($product, 'subtract', $quantity);
                }

            }
        }

        if($paymentMethod == 'cod') {
            event(new NewOrderPlaced($order));
        }



        return response()->json($order);
    }

    private function updateProductQuantity($product, $type, $quantity) {
        if($type == 'add') {
            $product->qty += $quantity;
        } else {
            $product->qty -= $quantity;
        }

        $product->save();
    }

    public function listOrders()
    {
        $orders = request()->user('customer')->orders()->orderBy('created_at', 'desc')->get();
        return OrderResource::collection($orders);
    }

    public function show(Order $order)
    {
        return view('customer.orders.show', ['order' => $order]);
    }
}
