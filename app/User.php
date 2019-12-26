<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Overtrue\LaravelLike\Traits\CanLike;
use Rennokki\Rating\Traits\CanRate;
use Rennokki\Rating\Contracts\Rater;
use Rennokki\Befriended\Traits\Follow;
use Rennokki\Befriended\Contracts\Following;

use App\Notifications\ResetPassword;

class User extends Authenticatable implements Rater, Following
{
    use HasApiTokens, Notifiable, CanLike, CanRate, Follow;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'website' . 'phone', 'profile_picture'
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

    /**
     * Get This User based on its token ??
     */
    public function getByToken($token)
    {
        return self::where('api_token', $token)->first();
    }

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPassword($token));
    }
}
