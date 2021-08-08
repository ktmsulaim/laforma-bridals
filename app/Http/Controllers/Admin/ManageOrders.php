<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusChanged;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManageOrders extends Controller
{
    public function index(Request $request)
    {
        return view('admin.orders.index');
    }

    public function listOrders(Request $request)
    {
        
        if($request->has('filter')) {
            $start = $request->has('date_range') ? $request->get('date_range')[0] : null;
            $end = $request->has('date_range') ? $request->get('date_range')[1] : null;
            $status = $request->get('status');

            if($start && $end && $status) {
                $orders = Order::where('created_at', '>=', Carbon::parse($start))->where('created_at', '<=', Carbon::parse($end))->where('status', $status)->get();
            } elseif($start && $end) {
                $orders = Order::where('created_at', '>=', Carbon::parse($start))->where('created_at', '<=', Carbon::parse($end))->get();
            } elseif($status) {
                $orders = Order::where('status', $status)->get();
            } else {
                $orders = Order::orderBy('id', 'desc')->get();
            }

            $count = count($orders);
        } else {
            $orders = Order::orderBy('id', 'desc');
            $count = Order::count();

            if($request->has('search')) {
                $search = $request->get('search');
                $orders = Order::whereHas('customer', function($query) use($search){
                    $query->where('name', 'like', "%$search%");
                    $query->orWhere('phone', '=', $search);
                })->with(['customer' => function($query) use($search){
                    $query->where('name', 'like', "%$search%");
                    $query->orWhere('phone', '=', $search);
                }]);
    
                $count = $orders->count();
            } 
            
            if($request->has('limit') && $request->has('offset')) {
               $orders = $orders->limit($request->get('limit'))->offset($request->get('offset'))->get();
            } else {
                $orders = $orders->get();
            }
        }
        
        
        $orders = $orders->transform(function ($order) {
            $currentYear = Carbon::now()->year;
            return [
                'id' => $order->id,
                'customer_name' => $order->customer->name,
                'customer_phone' => $order->customer->phone,
                'total' => $order->total,
                'status' => $order->status(),
                'created_at' => $currentYear === $order->created_at->year ? $order->created_at->format('F d') : $order->created_at->format('F d, Y'),
                'url' => [
                    'view' => route('admin.orders.show', $order->id)
                ]
            ];
        });

        $data = [
            'data' => $orders,
            'count' => $count
        ];

        return response()->json($data);
    }

    public function show(Request $request, Order $order)
    {
        return view('admin.orders.show', ['order' => $order]);
    }

    public function status(Request $request, Order $order)
    {
        $status = $request->get('status');

        if(!$request->has('status') || !$status) {
            return response()->json(['error' => "Status is missing"], 422);
        }

        $order->status = $status;
        $order->save();

        if(setting('email_notification') === 'enable' && setting('order_status_mail') === 'enable') {
            event(new OrderStatusChanged($order));
        }

        $order = $order->fresh();
        return response()->json($order->status());
    }

    public function print(Request $request, Order $order)
    {
        return view('admin.orders.print', ['order' => $order]);
    }
}
