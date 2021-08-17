<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $currentYear = Carbon::now()->year;

        return [
            'id' => $this->id,
            'customer' => $this->customer,
            'product' => $this->product,
            'reviewer_name' => $this->reviewer_name,
            'title' => $this->title,
            'review' => $this->review,
            'rating' => $this->rating,
            'status' => $this->status,
            'published' => optional($this->updated_at)->diffForHumans(),
            'created' => [
                'at' => $this->created_at,
                'formatted' => $this->created_at->year === $currentYear ? $this->created_at->format('F d') : $this->created_at->format('F d, Y')
            ]
        ];
    }
}
