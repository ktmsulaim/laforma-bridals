<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            'features' => $this->features,
            'hours' => $this->hours,
            'images' => [
                'base_image' => $this->baseImage(),
                'additional_images' => $this->additionalImages()
            ],
            'price' => [
                'net_price' => $this->price,
                'formatted' => $this->price()
            ],
            'special_price' => [
                'has_special_price' => $this->hasSpecialPrice(),
                'net_price' => $this->specialPrice(),
                'formatted' => $this->specialPrice(true),
            ],
            'booking_price' => [
                'net_price' => $this->bookingPrice(),
                'formatted' => $this->bookingPrice(true)
            ],
            'status' => $this->status,
            'url' => route('packages.show', $this->slug)
        ];
    }
}
