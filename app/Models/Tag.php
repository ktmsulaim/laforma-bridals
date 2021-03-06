<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SluggableTrait;

class Tag extends Model
{
    use HasFactory, SluggableTrait;

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
