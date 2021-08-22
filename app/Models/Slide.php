<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ImagesTrait;

class Slide extends Model
{
    use HasFactory, ImagesTrait;

    protected $guarded = [];

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
