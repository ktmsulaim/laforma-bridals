<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class WebsiteResourceController extends Controller
{
    public function featuredProducts(Request $request)
    {
        $products = Product::available()->orderBy('id', 'desc')->limit(8)->get();

        return ProductResource::collection($products);
    }
}
