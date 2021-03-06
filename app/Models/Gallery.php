<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ImagesTrait;
use App\Traits\SluggableTrait;

class Gallery extends Model
{
    use HasFactory, ImagesTrait, SluggableTrait;

    protected $guarded = [];

    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }
}
