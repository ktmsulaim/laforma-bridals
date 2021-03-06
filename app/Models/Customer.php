<?php

namespace App\Models;

use App\Notifications\Customer\Auth\ResetPassword;
use App\Notifications\Customer\Auth\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'google_id',
        'facebook_id',
        'name', 
        'photo', 
        'username', 
        'email', 
        'phone', 
        'password',
        'is_active',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function isActive()
    {
        return $this->is_active === 1;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function photo()
    {
        if($this->photo && $this->isExternal($this->photo)) {
            return $this->photo;
        } elseif($this->photo && Storage::exists($this->photo)) {
            return Storage::url($this->photo);
        } else {
            return asset('img/customer.svg');
        }
    }

    private function isExternal($file) {
        if($file) {
            $components = parse_url($file);
            return !empty($components['host']) && strcasecmp($components['host'], $_SERVER['SERVER_NAME']);
        }
        return false;
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlists');
    }
}