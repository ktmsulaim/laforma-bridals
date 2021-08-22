<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $slides = Slide::published()->orderBy('order')->get();
        return view('website.index', ['slides' => $slides]);
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

    public function cart()
    {
        return view('website.cart.index');
    }

    public function checkout()
    {
        return view('website.checkout.index');
    }
}
