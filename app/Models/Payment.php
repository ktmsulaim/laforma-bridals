<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function status()
    {
        return Str::of($this->status)->snake()->replace('_', ' ')->title();
    }
}
