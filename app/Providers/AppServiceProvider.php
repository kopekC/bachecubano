<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        $categories = Category::all();
        
        View::share('categories', $categories);
        View::share('total_ads', '120918');      //Load and cache this number everyday
    }
}
