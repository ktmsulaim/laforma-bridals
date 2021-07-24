<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function scopeBookingCharge($query)
    {
        return $query->where('type', 'booking_charge');
    }

    public function scopePackageAmount($query)
    {
        return $query->where('type', 'package_amount');
    }
}
