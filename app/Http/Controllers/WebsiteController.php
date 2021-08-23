<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Image;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $slides = Slide::published()->orderBy('order')->get();
        $featuredProduct = [
            'product' => Product::find(setting('featured_product_id')),
            'image' => Image::find(setting('featured_product_image')),
            'tag' => setting('featured_product_tag')
        ];

        $brands = [];

        if(setting('brands_images')) {
            $brands = Image::whereIn('id', setting('brands_images'))->get();
        }
        
        return view('website.index', ['slides' => $slides, 'featuredProduct' => $featuredProduct, 'brands' => $brands]);
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
