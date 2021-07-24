<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public static function totalBookedHoursOn($date)
    {
        $hours = 0;

        if(static::where('date', $date)->exists()) {
            foreach (static::where('date', $date)->get() as  $booking) {
                $hours += $booking->package->hours;
            }
        }

        return $hours;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function bookingCharge()
    {
        return $this->payments()->bookingCharge()->first();
    }

    public function packageAmount()
    {
        return $this->payments()->packageAmount()->first();
    }

    public static function nextID()
    {
        if(static::count()) {
            $last = self::orderBy('id', 'desc')->first();

            return $last->id + 1;
        } else {
            return 1;
        }
    }

    public function summary()
    {
        $formattedDate = Carbon::parse($this->date)->format('d F, Y');

        return $this->time . '@' . $formattedDate;
    }

    public function date()
    {
        return $this->date ? Carbon::parse($this->date)->format('d/m/Y') : null;
    }

    public function status()
    {
        return Str::of($this->status)->snake()->replace('_', ' ')->title();
    }
    
    public function progress()
    {
        return Str::of($this->progress)->snake()->replace('_', ' ')->title();
    }
}
