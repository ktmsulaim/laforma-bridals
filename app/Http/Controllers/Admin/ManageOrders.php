<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ManageOrders extends Controller
{
    public function index(Request $request)
    {
        return view('admin.orders.index');
    }

    public function listOrders(Request $request)
    {
        $orders = Order::orderBy('id', 'desc')->get();
        $orders = $orders->transform(function ($order) {
            return [
                'id' => $order->id,
                'customer_name' => $order->customer->name,
                'customer_phone' => $order->customer->phone,
                'total' => $order->total,
                'status' => $order->status(),
                'created_at' => $order->created_at->format('F d, Y'),
                'url' => [
                    'view' => route('admin.orders.show', $order->id)
                ]
            ];
        });

        return response()->json($orders);
    }

    public function show(Request $request, Order $order)
    {
        return view('admin.orders.show', ['order' => $order]);
    }

    public function status(Request $request, Order $order)
    {
        # code...
    }

    public function print(Request $request, Order $order)
    {
        return view('admin.orders.print', ['order' => $order]);
    }
}
