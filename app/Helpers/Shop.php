<?php

namespace App\Helpers;

use App\Models\Booking;
use App\Models\Package;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Cmixin\BusinessTime;
use DateInterval;
use DateTime;

class Shop
{
    public static function isShopOpen()
    {
        $now = Carbon::now();
        $open = Carbon::parse(setting('opening_hour', '8:00 AM'));
        $close = Carbon::parse(setting('closing_hour', '8:00 PM'));

        return $now->gt($open) && $now->lt($close);
    }

    public static function isWorkingHour($time)
    {
        if (!$time instanceof Carbon) {
            $time = Carbon::parse($time);
        }

        $open = Carbon::parse(setting('opening_hour', '8:00 AM'));
        $close = Carbon::parse(setting('closing_hour', '8:00 PM'));

        return $time->between($open, $close);
    }

    public static function getOpeningClosingHours()
    {
        $opening = Carbon::parse(setting('opening_hour', '08:00 AM'));
        $closing = Carbon::parse(setting('closing_hour', '08:00 PM'));

        if ($opening && $closing) {
            return ["{$opening->format('H:i')}-{$closing->format('H:i')}"];
        }
    }

    public static function getTimeSlots($checkDate)
    {
        $booked = Booking::where('date', $checkDate)->get();

        $opening = Carbon::parse(setting('opening_hour', '8:00 AM'));
        $closing = Carbon::parse(setting('closing_hour', '8:00 PM'));

        $available = [];

        if (!$checkDate instanceof Carbon) {
            $checkDate = Carbon::parse($checkDate);
        }

        BusinessTime::enable(Carbon::class, [
            'monday' => self::getOpeningClosingHours(),
            'tuesday' => self::getOpeningClosingHours(),
            'wednesday' => self::getOpeningClosingHours(),
            'thursday' => self::getOpeningClosingHours(),
            'friday' => self::getOpeningClosingHours(),
            'saturday' => self::getOpeningClosingHours(),
            'sunday' => self::getOpeningClosingHours(),
            'exceptions' => [
                function (Carbon $date) {
                    $holidays = setting('holidays', []);

                    if ($holidays) {
                        return !in_array($date->format('Y-m-d'), explode(',', $holidays));
                    }
                }
            ]
        ]);

        $period = CarbonPeriod::create(
            $opening,
            static fn (Carbon $checkDate) => $checkDate->nextOpen(),
            $closing,
        );

        foreach ($period as $slot) {
            array_push($available, $slot->format('h:i A'));
        }

        return $available;
    }

    public static function getTimeSlot()
    {
        $slots = [];

        $lower = strtotime(setting('opening_hour', '8:00 AM')); $upper = strtotime(setting('closing_hour', '8:00 PM')); $step = 3600;
        
        
        foreach ( range( $lower, $upper, $step ) as $increment ) {
            $increment = date( 'h:i A', $increment );     
            array_push($slots, $increment);
        }

        return $slots;
    }
}
