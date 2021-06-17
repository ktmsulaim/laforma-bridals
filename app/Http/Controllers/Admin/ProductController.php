<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
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

        $data = $request->all();

        // 1. Make slug
        $data['slug'] = str_slug($request->name);

        // 2. Create product
        // $product = Product::create($data);
        $product = Product::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'price' => $data['price'],
            'special_price' => $data['special_price'],
            'special_price_type' => $data['special_price_type'],
            'special_price_start' => $data['special_price_start'],
            'special_price_end' => $data['special_price_end'],
            'sku' => $data['sku'],
            'in_stock' => $data['in_stock'],
            'qty' => $data['qty'],
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
            'is_new' => $data['is_new'],
            'new_from' => $data['new_from'],
            'new_to' => $data['new_to'],
            'is_active' => $data['is_active'],
        ]);

        // 3. Attach base image
        if($request->has('base_image')) {
            $product->images()->attach($request->get('base_image'), [
                'type' => 'base_image'
            ]);
        }

        // 4. Attach additional images
        if($request->has('additional_images')) {
            $additional_images = $request->get('additional_images');

            if(is_array($additional_images) && count($additional_images)) {
                foreach($additional_images as $aimage) {
                    $product->images()->attach($aimage, [
                        'type' => 'additional_images'
                    ]);
                }
            }
        }

        Toastr::success('The product has been created.', 'Created');

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

        $data = $request->except(['base_image', 'additional_images']);

        // if title is changed change slug
        if($data['name'] != $product->name) {
            $data['slug'] = str_slug($data['name']);
        }

        if($request->has('base_image')) {
            $image = $request->get('base_image');
            if(!$product->images()->wherePivot('type', '=', 'base_image')->exists()) {
                $product->images()->attach($image, [
                    'type' => 'base_image'
                ]);
            } else {
                $product->images()->wherePivot('type', '=', 'base_image')->sync([$image => ['type' => 'base_image']]);
            }
        }

        if($request->has('additional_images')) {
            $additional_images = $request->get('additional_images');
            if($product->images()->wherePivot('type', '=', 'additional_images')->exists()) {
                
                if(is_array($additional_images) && count($additional_images)) {
                    $new = [];
                    foreach($additional_images as $ai) {
                        $new[$ai] = ['type' => 'additional_images'];
                    }

                    $product->images()->wherePivot('type', '=', 'additional_images')->sync($new);
                }
            } else {
                foreach($additional_images as $aimage) {
                    $product->images()->attach($aimage, [
                        'type' => 'additional_images'
                    ]);
                }
            }
        }

        $product->update($data);

        Toastr::success('The product has been updated!', 'Updated');

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
        //
    }
}
