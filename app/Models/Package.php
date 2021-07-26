<?php

namespace App\Models;

use App\Helpers\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ImagesTrait;
use App\Traits\SluggableTrait;
use App\Traits\PriceTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class Package extends Model
{
    use HasFactory, ImagesTrait, SluggableTrait, PriceTrait;

    protected $guarded = [];

    public function setFeaturesAttribute($val)
    {
        if ($val && is_array($val)) {
            $this->attributes['features'] = json_encode($val);
        }
    }

    public function getFeaturesAttribute($val)
    {
        if ($val) {
            return json_decode($val, true);
        }
    }

    public function scopeAvailable($query)
    {
        return $query->where("status", 1);
    }

    public function bookingPrice($format = false)
    {
        if ($this->booking_price) {
            if ($this->booking_price_type == 'fixed') {
                $price = $this->booking_price;
            } elseif ($this->booking_price_type == 'percentage') {
                $percentage = ($this->price * $this->booking_price) / 100;
                $price = $percentage;
            }

            if ($format) {
                return Money::format($price);
            } else {
                return round($price, 2);
            }
        }

        return 0;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function duration($type = 'minutes')
    {
        if ($type === 'hours') {
            return $this->hours;
        } elseif ($type === 'minutes') {
            $decimalHours = $this->hours;

            $hours = floor($decimalHours);

            $mins = round(($decimalHours - $hours) * 60);

            $timeInMinutes = ($hours * 60) + $mins;

            return $timeInMinutes;
        }
    }

    public function isAvailableOn($date)
    {
        if ($date) {
            if (!$date instanceof Carbon) {
                $dt = Carbon::parse($date);

                if (!$dt->gte(Carbon::today())) {
                    return false;
                }


                $date = $dt->format('Y-m-d');
            }

            $totalBookedHours = Booking::totalBookedHoursOn($date);

            $totalWorkingHours = setting('working_hours', 12);

            if ($totalWorkingHours >= $totalBookedHours + $this->hours) {
                return true;
            }
        }

        return false;
    }


    public function getAvailableSlots($date)
    {
        $availableSlots = [];

        if ($this->isAvailableOn($date)) {
            $opening = Carbon::parse(setting('opening_hour', '8:00 AM'));
            $closing = Carbon::parse(setting('closing_hour', '8:00 PM'));

            $hours = new CarbonPeriod(
                $opening,
                $this->duration() . ' minutes',
                $closing->subMinutes($this->duration())
            );

            $hours->addFilter(function($date) {
                $toSkip = [];
                $today = Carbon::now();

                if($today->format('d-m-Y') === $date->format('d-m-Y')) {
                    if($date->hour === $today->hour && $date->addMinutes($this->duration() > $today->hour)) {
                        array_push($toSkip, $date);
                    } elseif($date->hour < $today->hour) {
                        array_push($toSkip, $date);
                    }
                }

                return !in_array($date, $toSkip);
            });
            
            if (Booking::where('date', $date)->count()) {
                $totalBookedHours = Booking::totalBookedHoursOn($date);
                $timeLeft = setting('working_hours', 12) - $totalBookedHours;

                if ($timeLeft >= $this->hours) {
                    $booked = Booking::where('date', $date)->get();
                    

                    $hours->addFilter(function ($date) use ($booked) {
                        $toSkip = [];
                        foreach ($booked as $bookedItem) {
                            $bookingTime = Carbon::parse($bookedItem->time);
                            $completingTime = Carbon::parse($bookedItem->time)->addMinutes($bookedItem->package->duration());

                            if ($bookedItem->status !== 'cancelled' && $date->isBetween($bookingTime, $completingTime)) {
                                array_push($toSkip, $date);
                            }
                        }

                        return !in_array($date, $toSkip);
                    });
                }
            }
            
            if ($hours->count()) {
                foreach ($hours as $hour) {
                    array_push($availableSlots, $hour->format('h:i A'));
                }
            }
        }


        return $availableSlots;
    }

}
