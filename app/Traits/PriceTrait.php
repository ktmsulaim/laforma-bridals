<?php

namespace App\Traits;

use App\Helpers\Money;
use Carbon\Carbon;

trait PriceTrait {
    public function price()
    {
        if($this->price) {
            return Money::format($this->price);
        }
    }

    public function specialPrice($format = true)
    {
        if($this->special_price) {
            if($this->special_price_type == 'fixed') {
                $price = $this->special_price;
            } elseif($this->special_price_type == 'percentage') {
                $percentage = ($this->price * $this->special_price) / 100;
                $price = $this->price - $percentage;
            }

            if($format) {
                return Money::format($price);
            } else {
                return $price;
            }
        }

        return 0;
    }

    public function specialPriceAmount()
    {
        if($this->hasSpecialPrice()) {
            if($this->special_price_type == 'fixed') {
                $price = $this->price - $this->special_price;
            } elseif($this->special_price_type == 'percentage') {
                $percentage = ($this->price * $this->special_price) / 100;
                $price = $percentage;
            }

            return $price;
        } else {
            return 0;
        }
    }

    public function hasSpecialPrice()
    {
        if($this->special_price) {
            $today = Carbon::now();
            $special_price_start = $this->special_price_start ? Carbon::parse($this->special_price_start) : null;
            $special_price_end = $this->special_price_end ? Carbon::parse($this->special_price_end) : null;

            if(!$special_price_start) {
                return false;
            }

            if($special_price_start && $special_price_end && $today->isBetween($special_price_start, $special_price_end)) {
                return true;
            } elseif($special_price_end && $today->format('Y-m-d') === $special_price_end->format('Y-m-d')) {
                return true;
            } 
            // if($today->gte($special_price_start)) {
            //     return true;
            // } elseif($special_price_end && $today->lte($special_price_end)) {
            //     return true;
            // } else {
            //     return false;
            // }

        }
        
        return false;
    }

    public function getSpecialPricePercentage()
    {
        if($this->special_price) {
            if($this->special_price_type == 'percentage') {
                return $this->special_price;
            } else {
                $diff = $this->price - $this->special_price;
                $percentage = ($diff / $this->price) * 100;
                return (float)number_format($percentage, 2);
            }
        }
    }

    public function special_price_end()
    {
        if($this->special_price_end) {
            return Carbon::parse($this->special_price_end)->format('Y/m/d');
        }
    }
}