<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Money;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Product;
use Carbon\CarbonPeriod;
use App\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('report_type');
        $typeFormatted = Str::of($type)->snake()->replace('_', ' ')->title();
        $date_range = $request->get('date_range');
        $limit = $request->get('limit');
        $status = $request->get('status');
        $data = [];
        $columns = ['#'];

        if($date_range) {
            $date_range = explode(',', $date_range);
        }

        switch ($type) {
            case 'products_stock':
                $data = Product::select('id', 'name', 'qty', 'in_stock', 'track_stock')->orderBy('qty')->paginate($limit ?: 20);
                array_push($columns, 'Name', 'Quantity', 'Stock availability', 'Track stock');
                break;
            case 'top_selling_products':
                $data = DB::table('order_products')
                        ->select('products.id', 'products.name', DB::raw('COUNT(orders.id) as orders_count'), DB::raw('SUM(order_products.qty) as qty'))
                        ->leftJoin('products', 'products.id', '=', 'order_products.product_id')
                        ->leftJoin('orders', 'orders.id', '=', 'order_products.order_id')
                        ->groupBy('order_products.product_id')
                        ->orderBy('orders_count', 'desc')
                        ->orderBy('qty', 'desc')
                        ->paginate($limit ?: 20)
                        ->withQueryString();
                
                array_push($columns, 'Name', 'Orders', 'Quantity');

                break;
            case 'top_wishlisted_products' :
                $data = Product::select('id', 'name')
                        ->whereHas('wishlist')
                        ->withCount('wishlist')
                        ->orderBy('wishlist_count', 'desc')
                        ->paginate($limit ?: 20)
                        ->withQueryString();
                array_push($columns, 'Name', 'Wishlist count');
                break;
            case 'sales_report':
                if($date_range && is_array($date_range)) {
                    $period = new CarbonPeriod($date_range[0], '1 day', $date_range[1]);

                    if($period && count($period)) {
                        $tempData = [];
                        foreach($period as $day) {
                            $ordersData = Order::where('status', $status ?: 'completed')->whereDate('created_at', $day->format('Y-m-d'));
                          
                            array_push($tempData, [
                                'date' => $day->format('d/m/Y'), 
                                'orders' => $ordersData->count(), 
                                'products' => OrderProduct::whereHas('order', fn($order) => $order->where('status', $status ?: 'completed')->whereDate('created_at', $day->format('Y-m-d')))->count(),
                                'total' => Money::format($ordersData->sum('total')),
                            ]);
                        }
                        
                        $data = (new Collection($tempData))->paginate(20)->withQueryString();
                    }
                }
                array_push($columns, 'Date', 'Orders', 'Products', 'Total');
                break;
            case 'bookings_report':
                if($date_range && is_array($date_range)) {
                    $period = new CarbonPeriod($date_range[0], '1 day', $date_range[1]);

                    if($period && count($period)) {
                        $tempData = [];
                        foreach($period as $day) {
                            $bookingsData = Booking::where('status', $status ?: 'completed')->whereDate('created_at', $day->format('Y-m-d'));
                          
                            array_push($tempData, [
                                'date' => $day->format('d/m/Y'), 
                                'bookings' => $bookingsData->count(), 
                                'total' => Money::format(Payment::where('type', 'booking_charge')->whereDate('created_at', $day->format('Y-m-d'))->sum('amount')),
                            ]);
                        }
                        
                        $data = (new Collection($tempData))->paginate(20)->withQueryString();
                    }
                }
                array_push($columns, 'Date', 'Bookings', 'Total');
                break;
            default:
                $data = [];
                break;
        }

        return view('admin.reports.index', [
            'type' => $typeFormatted,
            'dateRange' => $date_range,
            'data' => $data,
            'columns' => $columns
        ]);
    }
}
