<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Ad;

use SEOMeta;
use OpenGraph;
use Twitter;

use Spatie\SchemaOrg\Schema;

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
        //SEO Data
        $seo_data = [
            'title' => 'Computadoras, celulares, electrodométicos, casas y carros en Cuba',
            'desc' => 'Web de negocios, tiendas y clasificados en Cuba. Especialidad en computadoras, celulares, accesorios, electrodomésticos, casas, carros y compras online.',
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addImage(asset('android-chrome-512x512.png'));
        Twitter::setTitle($seo_data['title']);

        //Latest Ads (With Photo only)
        $latest_ads = Ad::where('active', 1)
            ->with(['description', 'resources', 'category.description', 'category.parent.description'])
            ->has('resources')  //Has Pictures...
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        //Featured Listing, Diamond and Gold Random
        $promoted_ads = Ad::where('active', 1)
            ->with(['description', 'resources', 'category.description', 'category.parent.description', 'promo']) //<- Nested Load Category, and Parent Category
            ->whereHas('promo', function ($query) {
                $query->where('promotype', '>=', 3);
            })
            ->inRandomOrder()
            ->take(8)
            ->get();

        //testimonial
        //Try to fetch from facebook isn't with JS

        //blog posts        
        //First Make the blog 🤣

        //Schema
        $SchemaLD = Schema::localBusiness()
            ->name('Bachecubano')
            ->image(asset('android-chrome-512x512.png'))
            ->address("Calle 35 #1477 entre 26 y 28, Nuevo Vedado, La habana, Cuba")
            ->email('contacto@bachecubano.com')
            ->telephone("+5355149081")
            ->priceRange('$$')
            ->aggregateRating('5')
            ->brand('Bachecubano')
            ->employee('3')
            ->contactPoint(Schema::contactPoint()->areaServed('Cuba'));

        //Analize the variable submit, could be better
        return view('welcome', compact('latest_ads', 'promoted_ads', 'SchemaLD'));
    }
}
