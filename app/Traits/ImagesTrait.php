<?php

namespace App\Traits;
use App\Models\Image;

trait ImagesTrait {
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable')->withPivot('type');
    }

    public function baseImage()
    {
        if($this->images()->exists()){
            $image = $this->images()->wherePivot('type', '=', 'base_image')->first();

            if($image && $image->isFileExists()) {
                return $image->path;
            }
        } else {
            return asset('img/470x290.png');
        }
    }

    public function additionalImages()
    {
        if($this->images()->exists()) {
            return $this->images()->wherePivot('type', '=', 'additional_images')->get();
        }
    }
}