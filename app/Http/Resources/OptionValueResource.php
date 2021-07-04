<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionValueResource extends JsonResource
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
            'label' => $this->label,
            'price' => [
                'net_price' => $this->price,
                'original' => $this->price(),
                'formatted' => $this->price(true),
            ],
            'price_type' => $this->price_type,
            'position' => $this->position
        ];
    }
}
