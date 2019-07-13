<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Category Class, All indexes, Order and relations.
 */
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

    /**
     * Get the phone record associated with the user.
     */
    public function stats()
    {
        return $this->hasOne('App\CategoryStats');
    }
}

/**
 * SubClass which load metadata from this category
 */
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

/**
 * SubClass which says the total adas from category
 */
class CategoryStats extends Model
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
