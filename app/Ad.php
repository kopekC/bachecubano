<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * ads, ad_description, ad_location, ad_promo, ad_resource, ad_stats
 */
class Ad extends Model
{
    /**
     * Get the ad description
     */
    public function description()
    {
        return $this->hasOne('App\AdDescription');
    }

    /**
     * Get the location
     */
    public function location()
    {
        return $this->hasOne('App\AdLocation');
    }

    /**
     * Get the location
     */
    public function promo()
    {
        return $this->hasOne('App\AdPromo');
    }

    /**
     * Get the location
     */
    public function resources()
    {
        return $this->hasMany('App\AdResource');
    }

    /**
     * Get the location
     */
    public function stats()
    {
        return $this->hasOne('App\AdStats');
    }
}

class AdDescription extends Model
{
    //
}

class AdLocation extends Model
{
    //
}

class AdPromo extends Model
{
    //
}

class AdResource extends Model
{
    //
}

class AdStats extends Model
{
    //
}
