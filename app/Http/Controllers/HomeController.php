<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use SEOMeta;
use OpenGraph;
use Twitter;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //SEO Data
        $seo_data = [
            'title' => "Panel Principal en Bachecubano",
            'desc' => "Análisis de estadísticas y gestión de mi perfil en Bachecubano",
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');

        //Most Popular Ads

        //Most useful Stats about my ads
        

        return view('user.home');
    }
}
