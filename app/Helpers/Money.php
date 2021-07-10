<?php

namespace App\Helpers;

class Money {
    public static function format($val)
    {
        if($val) {
            if($val < 0) {
                $val = str_replace('-', '', $val);
                return '-₹' . number_format($val, 2); 
            } else {
                return '₹' . number_format($val, 2);
            }
        }
    }

    public static function toRazorPay($val)
    {
        if($val) {
            return $val * 100;
        }
    }
}