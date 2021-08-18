<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'cover' => $this->baseImage(),
            'images' => [
                'total' => $this->additionalImages()->count(),
            ],
            'created' => [
                'at' => $this->created_at,
                'formatted' => $this->created_at->format('F d, Y')
            ]
        ];
    }
}
