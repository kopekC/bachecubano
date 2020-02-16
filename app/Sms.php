<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Sms extends Model
{
    //Allow this model to be used as Notifications feature for fronted animations
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'phone', 'message', 'status'
    ];

    /**
     * Get the user that owns this SMS.
     */
    public function owner()
    {
        return $this->belongsTo('App\User');
    }
}
