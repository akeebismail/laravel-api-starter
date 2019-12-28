<?php


namespace App\Models;

use App\Services\Hasher;
use Illuminate\Foundation\Auth\User;

abstract class Authenticatable extends User
{
    protected $appends = ['idd'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','verification_code', 'id'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getIddAttribute()
    {
        return Hasher::encode($this->attributes['id']);
    }
}
