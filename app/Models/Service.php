<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ImagesTrait;
use App\Traits\SluggableTrait;

class Service extends Model
{
    use HasFactory, ImagesTrait, SluggableTrait;

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

    public function price()
    {
        if($this->price) {
            return '₹' . number_format($this->price, 2);
        }
    }
}
