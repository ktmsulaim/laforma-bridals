<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class WebsiteResourceController extends Controller
{
    public function allProducts(Request $request)
    {
        $categories = Category::active()->get();
        $tags = Tag::all();
        $maxPrice = Product::maxPrice();
        
        $search = $request->get('search');


        if($categories) {
            $categories = $categories->transform(fn($category) => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'products' => $search ? $category->products()->where('name', 'like', "%{$search}%")->count() : $category->products->count(),
            ]);
        }

        if($tags) {
            $tags =  $tags->transform(fn($tag) => [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
                'products' => $search ? $tag->products()->where('name', 'like', "%{$search}%")->count() : $tag->products->count(),
            ]);
        }

        return view('website.products.index', 
        [
            'categories' => $categories, 
            'tags' => $tags,
            'maxPrice' => $maxPrice,
            'search' => $search,
        ]);
    }

    public function getProducts(Request $request)
    {
        
        $categories = json_decode(stripslashes($request->get('categories')));
        $tags = json_decode(stripslashes($request->get('tags')));
        $price = json_decode(stripslashes($request->get('price')));
        $search = json_decode(stripslashes($request->get('search')));
        
        $products = Product::available();

        if($search) {
            $products->where('name', 'like', "%{$search}%");
        }

        if($categories && is_array($categories) && count($categories)) {
            $products->whereHas('category', function($query) use($categories){
                $query->whereIn('categories.id', $categories);
            });
        }

        if($tags && is_array($tags) && count($tags)) {
            $products->whereHas('tags', function($query) use($tags){
                $query->whereIn('tags.id', $tags);
            });
        }

        if($price) {
            $min = $price->min;
            $max = $price->max;

            if($min >= 0 && $max) {
                $products->where('price', '>=', $min)->where('price', '<=', $max);
            }
        }


        $products = $products->orderBy('id', 'desc')->paginate(20);
        return ProductResource::collection($products);            
    }

    public function getCategoryWiseFilteredProductsCount(Request $request)
    {
        $price = json_decode(stripslashes($request->get('price')));
        $categories = Category::active()->get();
        $tags = Tag::all();

        $hasPrice = false;

        if($price) {
            $min = $price->min;
            $max = $price->max;

            if($min >= 0 && $max) {
                $hasPrice = true;
            }
        }

        if($categories) {
            $categories = $categories->transform(fn($category) => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'products' => $hasPrice ? $category->products()->where(function($query) use($price){
                    $query->where('price', '>=', $price->min);
                    $query->where('price', '<=', $price->max);
                })->count() : $category->products->count(),
            ]);
        }

        if($tags) {
            $tags =  $tags->transform(fn($tag) => [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
                'products' => $hasPrice ? $tag->products()->where(function($query) use($price){
                    $query->where('price', '>=', $price->min);
                    $query->where('price', '<=', $price->max);
                })->count() : $tag->products->count(),
            ]);
        }

        return response()->json([
            'categories' => $categories,
            'tags' => $tags
        ]);

    }

    public function featuredProducts(Request $request)
    {
        $products = Product::available()->orderBy('id', 'desc')->limit(8)->get();

        return ProductResource::collection($products);
    }
}
