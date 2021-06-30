<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('website.index');
    }

    public function singleProduct($slug)
    {
        $product = Product::findBySlug($slug);
        
        return view('website.products.single', ['product' => $product]);
    }

    public function product(Product $product)
    {
        return new ProductResource($product);
    }
}
