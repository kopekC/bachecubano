<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Ad;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Bets Stores so far


        //Latest Ads (With Photo only)
        $latest_ads = Ad::where('active', 1)
            ->with(['description', 'resources', 'category.description', 'category.parent.description']) //<- Nested Load Category, and Parent Category
            ->has('resources')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        //Counter Stats


        //Featured Listing, Diamond and Gold Random
        $promoted_ads = Ad::where('active', 1)
            ->with(['description', 'resources', 'category.description', 'category.parent.description', 'promo']) //<- Nested Load Category, and Parent Category
            //->has('promo.promotype', '>=', 3)
            ->whereHas('promo', function ($query) {
                $query->where('promotype', '>=', 3);
            })
            ->inRandomOrder()
            ->take(8)
            ->get();

        //testimonial
        //Try to fetch from facebook isn't

        //blog posts        
        //First Make the blog 🤣

        //Analize the variable submit, could be better
        return view('welcome', compact('latest_ads', 'promoted_ads'));
    }
}
