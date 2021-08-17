<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function list()
    {
        $customer = auth('customer')->user();
        $products = $customer->wishlist;

        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'customer_id' => 'required|integer'
        ]);

        $customer = auth('customer')->user();

        if(!$customer) {
            return response()->json(['error' => 'You must login to add an item to the wishlist'], 401);
        }

        $productId = $request->get('product_id');
        $customerId = $request->get('customer_id');
        $wishlist = Wishlist::where(['product_id' => $productId, 'customer_id' => $customerId])->first();

        if(!$wishlist) {
            $wishlist = Wishlist::create(['product_id' => $productId, 'customer_id' => $customerId]);
        }

        return response()->json($wishlist);
    }

    public function destroy(Request $request)
    {
        $productId = $request->get('product_id');
        $customerId = $request->get('customer_id');
        $wishlist = Wishlist::where(['product_id' => $productId, 'customer_id' => $customerId])->first();

        if(!$wishlist) {
            return response()->json(['error' => "Bad request"], 404);
        }
        
        if(auth('customer')->id() !== $wishlist->customer_id) {
            return response()->json(['error' => "Unauthorized request"], 403);
        }

        $wishlist->delete();

        return response()->json([], 204);
    }
}
