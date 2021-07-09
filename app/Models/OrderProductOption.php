<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductOption extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['option', 'optionValue'];

    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class);
    }
}
