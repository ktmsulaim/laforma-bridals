<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax() && $request->has('list')) {
            $categories = Category::withCount('products')->with('childrenRecursive')->whereNull('parent')->get();
            $categoryList = Category::active()->get()->transform(function($category){
                $children = $category->getChildren();
                return [
                    'children' => $children ? $children->pluck('id')->toArray() : [],
                    'id' => $category->id,
                    'text' => $category->name
                ];
            });

            return response()->json([
                'categories' => $categories,
                'categoryList' => $categoryList

            ]);
        }

        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateData();

        $category = Category::create($request->all());

        return response()->json($category);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validateData();

        $category->update($request->all());

        $category = $category->fresh();

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([], 204);
    }

    private function validateData() {
        return request()->validate([
            'name' => 'required',
            'slug' => 'required',
            'is_orderable' => 'required',
            'show_in_nav' => 'required',
            'status' => 'required'
        ]);
    }
}
