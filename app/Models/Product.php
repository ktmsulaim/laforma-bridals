<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ImagesTrait;
use App\Traits\SluggableTrait;


class Product extends Model
{
    use HasFactory, ImagesTrait, SluggableTrait;

    protected $guarded = [];


    public function price()
    {
        if($this->price) {
            return '₹' . number_format($this->price, 2);
        }
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
