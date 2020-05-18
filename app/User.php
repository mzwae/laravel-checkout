<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'stripe_customer_id', 'strip_connect_id'
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

    /**
     * Return all product bought by a user
     * 
     */
    public function products(){
        return $this->hasMany(Product::class, 'seller_id', 'id');
    }

    /**
     * Return all payments that belong to a user
     * 
     */
    public function payments(){
        return $this->hasMany(Payment::class, 'customer_id', 'id');
    }


}
