<?php

namespace App\Helpers;

use Carbon\Carbon;

class Shop {
    public static function isShopOpen()
    {
        $now = Carbon::now();
        $open = Carbon::parse(setting('opening_hour', '8:00 AM'));
        $close = Carbon::parse(setting('closing_hour', '8:00 PM'));

        return $now->gt($open) && $now->lt($close);
    }

    public static function isWorkingHour($time)
    {
        if(!$time instanceof Carbon) {
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

        if($opening && $closing) {
            return ["{$opening->format('H:i')}-{$closing->format('H:i')}"];
        }
    }
}