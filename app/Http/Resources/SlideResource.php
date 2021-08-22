<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
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
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'overlay' => $this->overlay,
            'action_button_link' => $this->action_button_link,
            'action_button_text' => $this->action_button_text,
            'order' => $this->order,
            'status' => $this->status,
            'text_direction' => $this->text_direction,
            'base_image' => $this->getBaseImage()
        ];
    }
}
