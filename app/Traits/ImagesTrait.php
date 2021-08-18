<?php

namespace App\Traits;
use App\Models\Image;

trait ImagesTrait {
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable')->withPivot('type')->orderBy('type', 'desc');
    }

    public function hasBaseImage()
    {
        if(!$this->images()->exists()){
            return false;
        }

        $image = $this->images()->wherePivot('type', '=', 'base_image')->first();

        return $image && $image->isFileExists();
    }

    public function getBaseImage()
    {
        if($this->hasBaseImage()) {
            return  $this->images()->wherePivot('type', '=', 'base_image')->first();
        }
    }

    public function baseImage()
    {
        if($this->hasBaseImage()){
            $image = $this->images()->wherePivot('type', '=', 'base_image')->first();

            return $image->path;
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
        
        if($this->hasBaseImage()) {
            $image = $this->baseImage();

            if(is_object($image)) {
                array_push($data, $image->path);
            } elseif(is_string($image)) {
                array_push($data, $image);
            }
        }

        $additionalImages = $this->additionalImages();

        if($additionalImages && count($additionalImages)) {
            foreach($additionalImages as $image) {
                array_push($data, $image->path);
            }
        }


        return $data;
    }
}