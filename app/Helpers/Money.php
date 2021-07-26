<?php

namespace App\Helpers;

class Money {
    public static function format($val)
    {
        if($val) {
            if($val < 0) {
                $val = str_replace('-', '', $val);
                $price = '-₹' . number_format($val, 2); 
            } else {
                $price = '₹' . number_format($val, 2);
            }

            str_replace('.00', '', $price);

            return $price;
        }
    }

    public static function toRazorPay($val)
    {
        if($val) {
            return $val * 100;
        }
    }
}