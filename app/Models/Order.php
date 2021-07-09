<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['address'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function status()
    {
        return Str::of($this->status)->snake()->replace('_', ' ')->title();
    }

    public function paymentMethod()
    {
        if($this->payment_method == 'cod') {
            return 'Cash On Delivery';
        } elseif($this->payment_method == 'razorpay') {
            return 'Razorpay';
        } else {
            return 'Unknown';
        }
    }
}
