<?php

namespace App\Http\Controllers;

use App\Events\ReviewPosted;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function get(Request $request)
    {
        $product = Product::findOrFail($request->get('product'));
        $limit = 10;

        if(!$product) {
            return response()->json(['error' => "Unable to find the product"], 404);
        }

        $reviews = $product->reviews()
                           ->published()
                           ->orderBy('id', 'desc')
                           ->paginate($limit); 

        return ReviewResource::collection($reviews); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer',
            'product_id' => 'required|integer',
            'reviewer_name' => 'required',
            'title' => 'required|max:50',
            'review' => 'required',
            'rating' => 'required',
            'status' => 'integer'
        ]);

        $review = Review::create($request->all());

        event(new ReviewPosted($review));

        return response()->json(new ReviewResource($review));
    }
}
