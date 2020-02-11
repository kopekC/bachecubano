<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'credits'
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function owner()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Deduce certain amount of money
     */
    public function deduce($amount)
    {
        $this->decrement('credits', $amount);
    }

    /**
     * Acredit some momey to the user
     * $this->increment('points', 50);
     */
    public function credit($amount)
    {
        $this->increment('credits', $amount);
    }
}
