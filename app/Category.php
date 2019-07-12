<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the phone record associated with the user.
     */
    public function description()
    {
        return $this->hasOne('App\CategoryDescription');
    }
}

class CategoryDescription extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the user that owns the phone.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
