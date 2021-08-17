<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function list(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit');
        $offset = $request->get('offset');
        $customer = auth('customer')->user();

        $reviews = $customer->reviews()->orderBy('id', 'desc');

        if($request->has('limit') && $request->has('offset')) {
            $reviews->limit($limit)->offset($offset);
        }

        if($request->has('search') && $search) {
            $reviews->where(function($query) use($search){
                $query->where('title', 'like', "%$search%");
                $query->orWhere('reviewer_name', 'like', "%$search%");
            });
        }

        $reviews = $reviews->get();

        return ReviewResource::collection($reviews)->additional(['count' => Review::count(), 'offset' => $request->get('offset') ?: 0]);
    }

    public function show(Review $review)
    {
       $this->checkAuthor($review);

        return view('customer.reviews.show', ['review' => $review]);
    }

    public function update(Request $request, Review $review)
    {
       $this->checkAuthor($review);

        $request->validate([
            'customer_id' => 'required|integer',
            'product_id' => 'required|integer',
            'reviewer_name' => 'required',
            'title' => 'required|max:50',
            'review' => 'required',
            'rating' => 'required',
            'status' => 'integer'
        ]);

        $review->update($request->all());
        return response()->json($review);
    }

    public function destroy(Review $review)
    {
       $this->checkAuthor($review);

        $review->delete();

        return response()->json([], 204);
    }

    private function checkAuthor(Review $review) : bool
    {
        if(auth('customer')->check()) {
            if($review->customer_id !== auth('customer')->id()) {
                return redirect()->route('customer.reviews.index');
            }
        }

        return false;
    }
}
