<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Overtrue\LaravelLike\Traits\CanBeLiked;

class Post extends Model
{
    use CanBeLiked;

    // table name to be used
    protected $table = 'posts';

    // columns to be allowed in mass-assingment 
    protected $fillable = ['user_id', 'title', 'slug', 'body', 'cover'];

    /* Relations */
    // One to many inverse relationship with User model
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * get show post route
     *
     * @return string
     */
    public function path()
    {
        return "/blog/{$this->slug}";
    }
}
