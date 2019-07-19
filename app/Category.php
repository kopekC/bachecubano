<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

/**
 * Category Class, All indexes, Order and relations.
 */
class Category extends Model
{
    use Cachable;

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

    /**
     * Aprent Category Data if $this->parent_id != null
     */
    public function parent()
    {
        return $this->hasOne('App\Category', 'id', 'parent_id');
    }
}

/**
 * SubClass which load metadata from this category
 */
class CategoryDescription extends Model
{
    use Cachable;

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
    use Cachable;
    
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
