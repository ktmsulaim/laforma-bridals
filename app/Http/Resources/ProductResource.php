<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'base_image' => $this->baseImage(),
            'images' => $this->images()->exists() ? $this->images()->get()->transform(function($image){
                return $image->path;
            }) : null,
            'category' => [
                'name' => $this->category->name,
                'url' => route('products.index', ['category' => $this->category->slug]),
            ],
            'sku' => $this->sku,
            'tags' => $this->tags,
            'price' => [
                'original' => $this->price,
                'formatted' => $this->price(),
            ],
            'special_price' => [
                'has_special_price' => $this->hasSpecialPrice(),
                'original' => $this->specialPrice(false),
                'formatted' => $this->specialPrice(),
                'expires' => $this->special_price_end(),
                'percentage' => $this->getSpecialPricePercentage()
            ],
            'is_new' => $this->is_new(),
            'url' => route('singleProduct', $this->slug),
            'in_stock' => $this->inStock(),
            'qty' => $this->qty,
            'is_orderable' => $this->category->is_orderable && $this->is_orderable ? 1 : 0,
            'options' => [
                'has_options' => $this->hasOptions(),
                'items' => OptionResource::collection($this->options)
            ]
        ];
    }
}
