<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Traits\Controllers\Images;
use Carbon\Carbon;

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

    public function listProducts(Request $request)
    {
        $products = Product::latest();

        if($request->has('_type') && !empty($request->get('_type'))) {
            $products->available()
                     ->whereHas('category', fn($query) => $query->where('is_orderable', 1))
                     ->where('is_orderable', 1);
        }

        if($request->has('q') && !empty($request->get('q'))){
            $products->where('name', 'like', "%{$request->q}%");
        }

        $products= $products->get();

        $products->transform(function($product){
            $currentYear = Carbon::now()->year;
            return [
                'id' => $product->id,
                'image' => $product->baseImage(), 
                'name' => $product->name,
                'price' => $product->price(),
                'is_active' => $product->is_active,
                'created_at' => $currentYear === $product->created_at->year ? $product->created_at->format('d F') : $product->created_at->format('d F, Y'),
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

        $data = $request->except(['base_image', 'additional_images', 'tags', 'options']);

        // 1. Make slug
        $data['slug'] = $request->get('slug') ?: str_slug($request->name);

        // 2. Create product
        $product = Product::create($data);

        // 3. attach images
        $this->saveImages($request, $product);

        // 4. Attach tags if any
        if($request->has('tags')) {
            $tags = $request->get('tags');

            if($tags && is_array($tags) && count($tags)) {
                foreach ($tags as $key => $tag) {
                    $product->tags()->attach($tag);
                }
            }
        }

        // 5. create options if any
        if($request->has('options')) {
            $options = $request->options;

            $this->addOptions($options, $product);
        }

        return response()->json($product);
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
        $product->{'options'} = $product->options;

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

        $data = $request->except(['base_image', 'additional_images', 'tags', 'options']);

        // if title is changed change slug
        if($data['name'] != $product->name) {
            $data['slug'] = str_slug($data['name']);
        }

        // Attach tags if any
        if($request->has('tags')) {
            $tags = $request->get('tags');

            if($tags && is_array($tags) && count($tags)) {
                $product->tags()->sync($tags);
            }
        }

        // Update options 
        if($request->has('options')) {
            // if($product->options()->exists()) {
            //     $product->options()->delete();
            // }

            $options = $request->options;
            
            $this->addOptions($options, $product);
        }

        $product->update($data);

        $this->saveImages($request, $product);

        return response()->json($product);
    }

    private function addOptions($options, Product $product) {
        if($options && is_array($options) && count($options)) {
            foreach($options as $option) {
                $productOption = null;

                if($option['id']) {
                    $productOption = $product->options()->where('id', $option['id'])->first();
                }

                if($productOption) {
                    $productOption->update([
                        'name' => $option['name'],
                        'type' => $option['type'],
                        'is_required' => $option['is_required'],
                        'position' => $option['position']
                    ]);
                } else {
                    $productOption = $product->options()->create([
                        'name' => $option['name'],
                        'type' => $option['type'],
                        'is_required' => $option['is_required'],
                        'position' => $option['position']
                    ]);
                }


                if($option['values'] && is_array($option['values']) && count($option['values'])) {
                    foreach($option['values'] as $value) {
                        $productOptionValue = null;

                        if($value['id']) {
                            $productOptionValue = $productOption->values()->where('id', $value['id'])->first();
                        }

                        if($productOptionValue) {
                            $productOptionValue->update([
                                'label' => $value['label'],
                                'price' => $value['price'],
                                'price_type' => $value['price_type'],
                                'position' => $value['position'],
                                'in_stock' => $value['in_stock'],
                            ]);
                        } else {
                            $productOptionValue = $productOption->values()->create([
                                'label' => $value['label'],
                                'price' => $value['price'],
                                'price_type' => $value['price_type'],
                                'position' => $value['position'],
                                'in_stock' => $value['in_stock'],
                            ]);
                        }

                    }
                }
            }
        }
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
