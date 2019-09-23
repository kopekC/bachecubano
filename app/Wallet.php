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
     * Get the user that owns the wallet.
     */
    public function owner()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Deduce certain amount of money
     */
    public function deduce($amount) {
        $this->credits -= $amount;
        $this->update();
    }

    /**
     * Acredit some menoy to the user
     */
    public function credit($amount) {
        $this->credits += $amount;
        $this->update();
    }
}
