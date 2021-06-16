<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable')->withPivot('type');
    }

    public function baseImage()
    {
        if($this->images()->exists()){
            return $this->images()->wherePivot('type', '=', 'base_image')->first();
        }
    }

    public function additionalImages()
    {
        if($this->images()->exists()) {
            return $this->images()->wherePivot('type', '=', 'additional_images')->get();
        }
    }

    public function setSlugAttribute($value) {

        if (static::whereSlug($slug = str_slug($value))->exists()) {
    
            $slug = $this->incrementSlug($slug);
        }
    
        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug) {

        $original = $slug;
    
        $count = 2;
    
        while (static::whereSlug($slug)->exists()) {
    
            $slug = "{$original}-" . $count++;
        }
    
        return $slug;
    
    }
}
