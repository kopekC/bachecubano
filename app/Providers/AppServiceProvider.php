<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

use App\Category;
use App\Post;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Replace Default public folder location
        $this->app->bind('path.public', function () {
            return base_path('public_html');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Schema Default String Length
        Schema::defaultStringLength(191);

        //Global Cached Categories Data Cache one week
        $categories = Cache::rememberForever('cached_categories', function () {
            return Category::with('description')->get();
        });

        //Small foreach for some organized category structure
        $parent_categories = [];
        $category_formatted = [];
        foreach ($categories as $cat) {
            if (is_null($cat->parent_id)) {
                $parent_categories[] = $cat;
            } else {
                $category_formatted[$cat->parent_id][] = $cat->description;
            }
        }

        //Ad Submit Validation
        Validator::extend('banned_words', function ($attribute, $value, $parameters) {
            // Banned words
            $words = array('prestamo', 'finanzas', 'préstamo');
            foreach ($words as $word) {
                if (stripos($value, $word) !== false) return false;
            }
            return true;
        });

        //get Three Blog Posts and cache it for one day?
        $latest_blog_post = Cache::remember('latest_blog_post', 60 * 12, function () {
            return Post::latest()->limit(3)->get();
        });

        View::share('parent_categories', $parent_categories);
        View::share('category_formatted', $category_formatted);
        View::share('total_ads', '120918');      //Load and cache this number everyday
        View::share('total_users', '15421');      //Load and cache this number everyday
        View::share('latest_blog_post', $latest_blog_post);
    }
}
