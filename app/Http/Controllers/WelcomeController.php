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
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

            dump( $latest_ads);

        //Counter Stats


        //Featured Listing, Diamond and Gold Random


        //testimonial


        //blog posts        


        //Analize the variable submit, could be better
        return view('welcome', compact('latest_ads'));
    }
}
