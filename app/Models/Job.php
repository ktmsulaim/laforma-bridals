<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ImagesTrait;
use Illuminate\Support\Str;

class Job extends Model
{
    use HasFactory, ImagesTrait;

    protected $table = 'jobs_model';

    protected $guarded = [];

    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }

    public function summary()
    {
        if($this->description) {
            return Str::limit(strip_tags(htmlspecialchars_decode($this->description)), 150);
        }
    }

    public function type()
    {
        return $this->type === 'fulltime' ? 'Full time' : 'Part time';
    }
}
