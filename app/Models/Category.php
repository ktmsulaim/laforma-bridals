<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function parentRecursive()
    {
        return $this->parent()->with('parentRecursive');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeForNav($query)
    {
        return $query->where('show_in_nav', 1);
    }

    public function getChildren()
    {
        $children = new Collection();

        if($this->children()->count()) {
            foreach($this->children()->get() as $child) {
                $children->push($child);

                $children = $children->merge($child->getChildren());
            }
        }

       return $children;
    }
}
