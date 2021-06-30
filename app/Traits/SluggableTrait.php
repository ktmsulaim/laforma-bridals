<?php 

namespace App\Traits;

trait SluggableTrait {
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

    public static function findBySlug($slug)
    {
        return self::where('slug', $slug)->first();
    }
}