<?php

namespace App\Models;

use App\Helpers\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ImagesTrait;
use App\Traits\SluggableTrait;
use App\Traits\PriceTrait;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\This;

class Package extends Model
{
    use HasFactory, ImagesTrait, SluggableTrait, PriceTrait;

    protected $guarded = [];

    public function setFeaturesAttribute($val)
    {
        if($val && is_array($val)) {
            $this->attributes['features'] = json_encode($val);
        }
    }

    public function getFeaturesAttribute($val)
    {
        if($val) {
            return json_decode($val, true);
        }
    }

    public function scopeAvailable($query)
    {
        return $query->where("status", 1);
    }

    public function bookingPrice($format = false)
    {
        if($this->booking_price) {
            if($this->booking_price_type == 'fixed') {
                $price = $this->booking_price;
            } elseif($this->booking_price_type == 'percentage') {
                $percentage = ($this->price * $this->booking_price) / 100;
                $price = $percentage;
            }

            if($format) {
                return Money::format($price);
            } else {
                return (float)number_format($price, 2);
            }
        }

        return 0;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailableOn($date)
    {
        if($date && $this->bookings()->exists()) {
            if(!$date instanceof Carbon) {
                $date = Carbon::parse($date)->format('Y-m-d');
            }

            $bookings = static::whereHas('bookings', function($query) use ($date) {
                $query->where('date', $date);
            })->count();

            $totalHours = static::whereHas('bookings', function($query) use ($date) {
                $query->where('date', $date);
            })->sum('hours');


        }

        return false;
    }

}
