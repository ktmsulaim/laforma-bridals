<?php

namespace App\Traits;
use App\Models\Image;

trait ImagesTrait {
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable')->withPivot('type')->orderBy('type', 'desc');
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

    public function imagesForSlider()
    {
        $data = [];

        foreach($this->images as $image) {
            array_push($data, $image->path);
        }

        return $data;
    }
}