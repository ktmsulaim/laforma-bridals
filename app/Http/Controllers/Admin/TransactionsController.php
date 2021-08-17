<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Money;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index()
    {
        return view('admin.transactions.index');
    }

    public function list(Request $request)
    {
        $transactions = Transaction::orderBy('id', 'desc')->get();

        if($request->has('limit') && $request->has('offset')) {
            $transactions = Transaction::orderBy('id', 'desc')->limit($request->get('limit'))->offset($request->get('offset'))->get();
        }

        $transactions = $transactions->transform(function($transaction){
            return [
                'id' => $transaction->id,
                'order_id' => $transaction->order->id,
                'transaction_id' => $transaction->transaction_id,
                'created_at' => $transaction->created_at->format('F d, Y'),
                'amount' => Money::format($transaction->order->total),
                'urls' => [
                    'order' => route('admin.orders.show', $transaction->order->id)
                ]
            ];
        });

        $data = [
            'data' => $transactions,
            'count' => Transaction::count()
        ];
       

        return response()->json($data);
    }
}
