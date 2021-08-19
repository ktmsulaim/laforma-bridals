<?php

namespace App\Http\Controllers;


use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebsiteResourceController extends Controller
{
    public function allProducts(Request $request)
    {
        $categories = Category::active()->get();
        $tags = Tag::all();
        $maxPrice = Product::maxPrice();
        
        $search = $request->get('search');
        $category = $request->get('category');
        $tag = $request->get('tag');


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
            'query' => [
                'search' => $search,
                'category' => $category,
                'tag' => $tag,
            ],
        ]);
    }

    public function getProducts(Request $request)
    {
        
        $categories = json_decode(stripslashes($request->get('categories')));
        $tags = json_decode(stripslashes($request->get('tags')));
        $price = json_decode(stripslashes($request->get('price')));
        
        // query
        $search = json_decode(stripslashes($request->get('search')));
        // attributes
        $attributes = json_decode(stripslashes($request->get('attributes')));

        // sort
        $sort = $request->get('sort');

        
        $products = Product::available();

        if($search) {
            $products->where('name', 'like', "%{$search}%");
        }

        if($attributes) {
            $orderable = $attributes->orderable;
            $inStock = $attributes->in_stock;
            $isNew = $attributes->is_new;
            $hasOffer = $attributes->has_offer;

            if($orderable) {
                $products->where('is_orderable', 1)->whereHas('category', fn($query) => $query->where('is_orderable', 1));
            }
    
            if($inStock) {
                $products->where('in_stock', 1);
            }
    
            if($isNew) {
                $products->where('is_new', 1);
            }
    
            if($hasOffer) {
                $date = Carbon::today()->format('Y-m-d');
                $products->whereNotNull('special_price')->where('special_price_start', '<=', $date)->where('special_price_end', '<=', $date);
            }
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

        if($sort) {
            if($sort === 'date') {
                $products = $products->orderBy('created_at', 'desc');
            } elseif($sort === 'price') {
                $products = $products->orderBy('price', 'asc');
            } elseif($sort === 'price-desc') {
                $products = $products->orderBy('price', 'desc');
            } elseif($sort === 'popularity') {
                $products = $products->leftJoin('order_products','products.id','=','order_products.product_id')
                ->selectRaw('products.*, COALESCE(sum(order_products.qty),0) total')
                ->groupBy('products.id')
                ->orderBy('total','desc');
            } else {
                $products = $products->orderBy('id', 'desc');
            }
        } else {
            $products = $products->orderBy('id', 'desc');
        }

        $products = $products->paginate(20);

        return ProductResource::collection($products);            
    }

    public function featuredProducts(Request $request)
    {
        $products = Product::available()->orderBy('id', 'desc')->limit(8)->get();

        return ProductResource::collection($products);
    }

    public function latestCollection()
    {
        $images = Image::has('gallery')->with('gallery')->orderBy('id', 'desc')->limit(10)->get();

        return response()->json($images);
    }
}
