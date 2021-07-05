<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'full_name' => $this->full_name,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'district' => $this->district,
            'state' => $this->state,
            'phone' => $this->phone,
            'pincode' => $this->pincode,
            'landmark' => $this->landmark,
            'is_default' => $this->is_default,
            'created_at' => $this->created_at,
            'updated_at' => optional($this->updated_at)->diffForHumans(),
        ];
    }
}
