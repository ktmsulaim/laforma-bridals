<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ManageReviews extends Controller
{
    public function index()
    {
        return view('admin.reviews.index');
    }

    public function list(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit');
        $offset = $request->get('offset');

        $reviews = Review::orderBy('id', 'desc');

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
        return view('admin.reviews.show', ['review' => $review]);
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'status' => 'required|integer'
        ]);

        $review->status = $request->get('status');
        $review->timestamps = false; // Don't update updated_at
        $review->save();

        if($request->ajax()) {
            return response()->json($review->fresh());
        }

        Toastr::success('The status has been updated', 'Success');
        return redirect()->back();
    }
}
