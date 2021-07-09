<?php

namespace App\Http\Resources;

use App\Helpers\Money;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'total' => Money::format($this->total),
            'status' => $this->status(),
            'created_at' => $this->created_at->format('F d, Y'),
            'products' => $this->products,
            'url' => [
                'view' => route('customer.orders.show', $this->id)
            ],
        ];
    }
}
