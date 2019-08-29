<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Overtrue\LaravelLike\Traits\CanLike;
use Rennokki\Rating\Traits\CanRate;
use Rennokki\Rating\Contracts\Rater;

class User extends Authenticatable implements Rater
{
    use HasApiTokens, Notifiable, CanLike, CanRate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    protected $dates = [
        'banned_until'
    ];

    /**
     * Retorna Todo slos anuncios de este usuario
     */
    public function ads()
    {
        return $this->hasMany('App\Ad');
    }

    /**
     * Retorna la billetera de este user
     */
    public function wallet()
    {
        return $this->hasOne('App\Wallet')->withDefault([
            'credits' => 0.00
        ]);
    }
}
