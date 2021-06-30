<?php

namespace App\Helpers;

class Money {
    public static function format($val)
    {
        if($val) {
            return '₹' . number_format($val, 2);
        }
    }
}