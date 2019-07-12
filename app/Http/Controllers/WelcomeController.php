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

        //Retrieve Categories
        $categories = Category::all();

        return view('welcome');
    }
}
