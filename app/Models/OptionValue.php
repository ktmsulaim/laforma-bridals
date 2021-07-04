<?php

namespace App\Models;

use App\Helpers\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $orderBy = 'position';

    protected $orderDirection = 'ASC';

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function price($format = false)
    {
        $product = $this->option->product;
        $productPrice = $product->price;

        if($this->price && $this->price > 0) {
            if($this->price_type == 'fixed') {
                $finalPrice = $productPrice + $this->price;
            } elseif($this->price_type == 'percentage') {
                $percentagePrice = ($productPrice * $this->price) / 100;
                $finalPrice = $productPrice + $percentagePrice;
            }
    
            // check product has special price
            if($product->hasSpecialPrice()) {
                $specialPrice = $product->specialPriceAmount();
    
                if($specialPrice) {
                    $finalPrice = $finalPrice - $specialPrice;
                }
            }
            
            if($format) {
                return Money::format($finalPrice);
            } else {
                return $finalPrice;
            }
        } else {
            if($product->hasSpecialPrice()) {
                return $product->specialPrice($format);
            } else {
                return $format ? $product->price() : $productPrice;
            }
        }
    }
}
