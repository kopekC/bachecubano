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
    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'body', 'cover'];

    /* Relations */
    // One to many inverse relationship with User model
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Get the Post Category.
     */
    public function category()
    {
        return $this->belongsTo('App\PostCategory');
    }
}

/**
 * Blog Categories
 */
class PostCategory extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    // table name to be used
    protected $table = 'post_categories';

    /**
     * Childs cats
     */
    public function childs()
    {
        return $this->hasMany('App\Post', 'category_id', 'id');
    }
}
