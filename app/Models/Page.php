<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SluggableTrait;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, SluggableTrait;

    protected $guarded = [];

    public function setLayoutAttribute($val)
    {
        if($val) {
            $this->attributes['layout'] = serialize($val);
        }
    }

    public function getLayoutAttribute($val)
    {
        if($val) {
            return unserialize($val);
        }
    }

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    public function summary()
    {
        if($this->content) {
            return Str::limit(strip_tags(htmlspecialchars_decode($this->content)), 150);
        }
    }
}
