<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

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


        //Latest Ads


        //Counter Stats


        //Featured Listing, Diamond and Gold Random


        //testimonial


        //blog posts        


        return view('welcome');
    }
}
