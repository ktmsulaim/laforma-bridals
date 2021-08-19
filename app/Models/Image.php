<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function imageable()
    {
        return $this->morphedByMany(Product::class, 'imageable');
    }

    public function getPathAttribute($val)
    {
        if($val) {
            return Storage::url($val);
        }
    }

    public function isFileExists()
    {
        return $this->path && Storage::exists('media/' . pathinfo($this->path, PATHINFO_BASENAME));
    }

    public function getSizeAttribute($val)
    {
        if($val) {
            if ($val < 1024) {
                return "{$val} bytes";
            } elseif ($val < 1048576) {
                $size_kb = round($val/1024);
                return "{$size_kb} KB";
            } else {
                $size_mb = round($val/1048576, 1);
                return "{$size_mb} MB";
            }
        }
    }

    public function gallery()
    {
        return $this->morphedByMany(Gallery::class, 'imageable')->withPivot('type');
    }
}
