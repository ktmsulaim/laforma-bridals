<?php

namespace App\Models;

use App\Helpers\Money;
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

    public function date($format = 'd/m/Y')
    {
        return $this->date ? Carbon::parse($this->date)->format($format) : null;
    }

    public function status()
    {
        if($this->status === 'full_amount_pending') {
            return 'Booked';
        } else {
            return Str::of($this->status)->snake()->replace('_', ' ')->title();
        }
    }
    
    public function progress()
    {
        // date()
        return Str::of($this->progress)->snake()->replace('_', ' ')->title();
    }

    public function subTotal($format = true)
    {
        $bookingCharge = $this->package->bookingPrice();
        $packageAmount = $this->package->hasSpecialPrice() ? $this->package->specialPrice(false) : $this->package->price;
        $total = $bookingCharge + $packageAmount;

        if($format) {
            return Money::format($total);
        } else {
            return $total;
        }
    }

    public function amountPaid($format = true)
    {
        if($this->payments()->exists()) {
            $sum = $this->payments()->sum('amount');

            if($format) {
                return Money::format($sum);
            } else {
                return $sum;
            }
        }

        return 0;
    }

    public function total($format = true)
    {
        $amountToPay = $this->subTotal(false) - $this->amountPaid(false);

        if($amountToPay) {
            if($format) {
                return Money::format($amountToPay);
            } else {
                return $amountToPay;
            }
        } 

        return 0;
    }
}
