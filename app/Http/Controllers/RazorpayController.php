<?php

namespace App\Http\Controllers;

use App\Events\NewOrderPlaced;
use App\Helpers\Money;
use App\Models\Booking;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    protected $api;

    public function __construct() {
        $this->api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
    }


    public function getOrderId(Request $request, $type)
    {

        if($type == 'product') {

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
        } elseif($type == 'package') {
            $package_id = Booking::nextID();
            $amount = $request->get('amount');

            $rzpOrder = $this->api->order->create([
                'receipt' => "package_{$package_id}",
                'amount' => $amount * 100,
                'currency' => 'INR'
            ]);
        }

        return response()->json(collect($rzpOrder)->toArray());
    }

    public function makePayment(Request $request)
    {
       $orderId = $request->get('order_id');
       $order = Order::findOrFail($orderId);

       event(new NewOrderPlaced($order));

       if(!$orderId || !$order) {
           return response()->json(['error' => 'Unable to find the order'], 404);
       }

       $signature = $request->get('signature');
       $payment_id = $request->get('transaction_id');
       $razorpay_order_id = $request->get('razorpay_order_id');

       if(!$order->transaction()->exists()) {
           $order->transaction()->create([
                'transaction_id' => $payment_id,
                'order_id' => $request->get('order_id'),
                'razorpay_order_id' => $razorpay_order_id,
                'signature' => $signature,
                'payment_method' => $request->get('payment_method'),
                'status' => $request->get('status')
           ]);
       }

       $payment = $this->api->payment->fetch($request->get('transaction_id'));

       if($payment) {
           if($this->verifySignature($signature, $payment_id, $razorpay_order_id)) {
               $payment->capture(['amount' => Money::toRazorPay($order->total), 'currency' => "INR"]);
               
               $order->status = 'confirmed';
               $order->save();
               
               return response()->json([], 200);
           }
       }

       return response()->json(['error' => "Unable to process the payment"], 500);

    }

    public function makeBookingPayment(Request $request)
    {
        $booking = Booking::findOrFail($request->get('booking_id'));
        $bookingDateFormatted = Carbon::parse($booking->date)->format('d F, Y');

        if(!$request->has('booking_id') || !$request->get('booking_id') || !$booking) {
            return response()->json(['error' => 'Unable to find the booking!'], 404);
        }

        $razorpayPaymentId = $request->get('razorpay_payment_id');
        $razorpayOrderId = $request->get('razorpay_order_id');
        $signature = $request->get('signature');

        $payment = $booking->payments()->create([
            'razorpay_payment_id' => $razorpayPaymentId,
            'razorpay_order_id' => $razorpayOrderId,
            'signature' => $signature,
            'type' => $request->get('type'),
            'status' => $request->get('status'),
        ]);

        $razorpayPayment = $this->api->payment->fetch($request->get('razorpay_payment_id'));

        if($razorpayPayment) {
            if($this->verifySignature($signature, $razorpayPaymentId, $razorpayOrderId)) {
                $razorpayPayment->capture(['amount' => Money::toRazorPay($booking->package->bookingPrice()), 'currency' => "INR"]);
                
                $booking->status = 'full_amount_pending';
                $booking->save();
                
                return response()->json(['data' => "Your booking summary: {$booking->summary()}"]);
            }
        }

        return response()->json(['error' => 'Unable to process booking charge'], 500);
    }

    private function verifySignature($signature, $payment_id, $order_id) {
        if($signature && $payment_id && $order_id) {
            try {
                $this->api->utility->verifyPaymentSignature([
                    'razorpay_signature' => $signature,
                    'razorpay_payment_id' => $payment_id,
                    'razorpay_order_id' => $order_id
                ]);
            } catch (\Throwable $th) {
                return false;
            }

            return true;
        }
    }
}
