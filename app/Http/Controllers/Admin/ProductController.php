<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Traits\Controllers\Images;

class ProductController extends Controller
{
    use Images;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.index');
    }

    public function listProducts()
    {
        $products = Product::latest()->get();

        $products->transform(function($product){
            return [
                'id' => $product->id,
                'image' => $product->baseImage(), 
                'name' => $product->name,
                'price' => $product->price(),
                'is_active' => $product->is_active,
                'created_at' => $product->created_at->format('d F, Y'),
                'edit' => route('admin.products.edit', $product->id)
            ];
        });

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'base_image' => 'required',
            'qty' => 'required|numeric'
        ]);

        $data = $request->except(['base_image', 'additional_images', 'tags']);

        // 1. Make slug
        $data['slug'] = $request->get('slug') ?: str_slug($request->name);

        // 2. Create product
        $product = Product::create($data);

        // attach images
        $this->saveImages($request, $product);

        // 5. Attach tags if any
        if($request->has('tags')) {
            $tags = $request->get('tags');

            if($tags && is_array($tags) && count($tags)) {
                foreach ($tags as $key => $tag) {
                    $product->tags()->attach($tag);
                }
            }
        }

        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product->{'base_image'} = $product->images()->wherePivot('type', '=', 'base_image')->first();
        $product->{'additional_images'} = $product->images()->wherePivot('type', '=', 'additional_images')->get();
        $product->{'tags'} = $product->tags;

        return view('admin.products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'qty' => 'required|numeric'
        ]);

        $data = $request->except(['base_image', 'additional_images', 'tags']);

        // if title is changed change slug
        if($data['name'] != $product->name) {
            $data['slug'] = str_slug($data['name']);
        }

        // 5. Attach tags if any
        if($request->has('tags')) {
            $tags = $request->get('tags');

            if($tags && is_array($tags) && count($tags)) {
                $product->tags()->sync($tags);
            }
        }

        $product->update($data);

        $this->saveImages($request, $product);

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Detach images
        if($product->images()->exists()) {
            $product->images()->detach();
        }
        // Detach tags
        if($product->tags()->exists()) {
            $product->tags()->detach();
        }

        // Delete it self
        $product->delete();

        Toastr::success('The product has been deleted', 'Success');

        return Redirect::route('admin.products.index');
    }
}
