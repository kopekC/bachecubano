<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Illuminate\Support\Str;

class Post extends Model implements Feedable
{
    // table name to be used
    protected $table = 'posts';

    // columns to be allowed in mass-assingment 
    protected $fillable = ['user_id', 'title', 'slug', 'body'];

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

    //abstract methos required for Feedable interface
    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary(text_clean(Str::limit($this->description, 160)))
            ->updated($this->updated_at)
            ->link(route('blog_post', ['entry_slug' => $this->slug]))
            ->author("Admin");
    }

    //Method that will return all the items that must be displayed in the feed
    public static function getFeedItems()
    {
        return Post::limit(20)->latest()->get();
    }
}
