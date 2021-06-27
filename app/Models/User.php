<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'status',
        'is_active',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeAdmin($query)
    {
        return $query->where('role', 1);
    }
    
    public function scopeProductManager($query)
    {
        return $query->where('role', 2);
    }
    
    public function scopeWebsiteManager($query)
    {
        return $query->where('role', 3);
    }

    public function setPasswordAttribute($val)
    {
        if($val) {
            $this->attributes['password'] = bcrypt($val);
        }
    }
}
