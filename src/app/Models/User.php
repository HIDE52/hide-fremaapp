<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'img_url',
        'postcode',
        'address',
        'building',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderedItems()
    {
        return $this->belongsToMany(Item::class, 'orders');
    }

    public function likes()
    {
        return $this->belongsToMany(Item::class, 'likes')->withTimestamps();
    }

    public function isProfileComplete()
    {
        return !empty($this->postcode) && !empty($this->address);
    }
}
