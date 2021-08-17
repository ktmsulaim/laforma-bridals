<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ImagesTrait;
use App\Traits\SluggableTrait;
use App\Traits\PriceTrait;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory, ImagesTrait, SluggableTrait, PriceTrait;

    protected $guarded = [];

    public function scopeAvailable($query)
    {
        return $query->where(['is_active' => 1]);
    }

    public function inStock()
    {
        if($this->track_stock) {
            return $this->qty > 0;
        } else {
            return $this->in_stock;
        }
    }

    public function is_new()
    {
        if($this->is_new) {
            if(!$this->new_from && !$this->new_to) {
                return false;
            }
            $today = Carbon::now();
            $from = Carbon::parse($this->new_from);    
            $to = Carbon::parse($this->to);
            
            if($today->gte($from) && $today->lte($to)) {
                return true;
            }
        }   

        return false;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function hasOptions()
    {
        if($this->options()->exists()) {
            foreach($this->options as $option) {
                if(!$option->values()->exists()) {
                    return false;
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public static function maxPrice()
    {
        if(self::count()) {
            $max = self::max('price');
            
            if($max) {
                return $max;
            }
        }

        return 0;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function rating()
    {
        $totalReviews = $this->reviews()->count();
        $rating = $totalReviews ? $this->reviews()->avg('rating') : 0;

        return [
            'total' => $totalReviews,
            'rating' => $rating,
        ];
    }

}
