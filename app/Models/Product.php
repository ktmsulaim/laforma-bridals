<?php

namespace App\Models;

use App\Helpers\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ImagesTrait;
use App\Traits\SluggableTrait;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory, ImagesTrait, SluggableTrait;

    protected $guarded = [];

    public function scopeAvailable($query)
    {
        return $query->where(['is_active' => 1, 'is_orderable' => 1]);
    }

    public function price()
    {
        if($this->price) {
            return Money::format($this->price);
        }
    }

    public function special_price($format = true)
    {
        if($this->special_price) {
            if($this->special_price_type == 'fixed') {
                $price = $this->special_price;
            } elseif($this->special_price_type == 'percentage') {
                $percentage = ($this->price * $this->special_price) / 100;
                $price = $this->price - $percentage;
            }

            if($format) {
                return Money::format($price);
            } else {
                return (float)number_format($price, 2);
            }
        }

        return 0;
    }

    public function hasSpecialPrice()
    {
        if($this->special_price) {
            $today = Carbon::now();
            $special_price_start = $this->special_price_start ? Carbon::parse($this->special_price_start) : null;
            $special_price_end = $this->special_price_end ? Carbon::parse($this->special_price_end) : null;

            if(!$special_price_start) {
                return false;
            }

            if($today->gte($special_price_start)) {
                return true;
            } elseif($special_price_end && $today->lte($special_price_end)) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function getSpecialPricePercentage()
    {
        if($this->special_price) {
            if($this->special_price_type == 'percentage') {
                return $this->special_price;
            } else {
                $diff = $this->price - $this->special_price;
                $percentage = ($diff / $this->price) * 100;
                return (float)number_format($percentage, 2);
            }
        }
    }

    public function special_price_end()
    {
        if($this->special_price_end) {
            return Carbon::parse($this->special_price_end)->format('Y/m/d');
        }
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

}
