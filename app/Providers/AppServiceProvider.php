<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Global Cached Categories Data
        $categories = Category::with('description')->get(); //View How to Cache this!!!

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

        View::share('parent_categories', $parent_categories);
        View::share('category_formatted', $category_formatted);
        View::share('total_ads', '120918');      //Load and cache this number everyday
        View::share('total_users', '15421');      //Load and cache this number everyday
    }
}
