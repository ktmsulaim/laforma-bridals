<?php

namespace App\Http\Controllers;

use App\Helpers\Money;
use App\Models\Order;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    protected $api;

    public function __construct() {
        $this->api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
    }


    public function getOrderId(Request $request)
    {
        $orderId = $request->get('order_id');

        $order = Order::findOrFail($orderId);

        if(!$orderId || !$order) {
            return response()->json(['error' => 'Unable to fetch order data'], 422);
        }
        
        $rzpOrder = $this->api->order->create([
            'receipt' => "order_{$order->id}",
            'amount' => $order->total * 100,
            'currency' => 'INR'
        ]);

        return response()->json(collect($rzpOrder)->toArray());
    }

    public function makePayment(Request $request)
    {
       $orderId = $request->get('order_id');
       $order = Order::findOrFail($orderId);

       if(!$orderId || !$order) {
           return response()->json(['error' => 'Unable to find the order'], 404);
       }

       if(!$order->transaction()->exists()) {
           $order->transaction()->create([
                'transaction_id' => $request->get('transaction_id'),
                'order_id' => $request->get('order_id'),
                'razorpay_order_id' => $request->get('razorpay_order_id'),
                'signature' => $request->get('signature'),
                'payment_method' => $request->get('payment_method'),
                'status' => $request->get('status')
           ]);
       }

       $payment = $this->api->payment->fetch($request->get('transaction_id'));

       if($payment) {
           $payment->capture(['amount' => Money::toRazorPay($order->total), 'currency' => "INR"]);
       }

       $order->status = 'confirmed';
       $order->save();

       return response()->json([], 200);
    }
}
