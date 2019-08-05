<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use SEOMeta;
use OpenGraph;
use Twitter;

use Illuminate\Support\Facades\Auth;
use App\Ad;

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

        //Total active ads
        $total_active_ads = Auth::user()->ads->count();

        //Total Promoted Ads
        $total_promoted_ads = Ad::where('active', 1)
            ->where('user_id', Auth::user()->id)
            ->whereHas('promo', function ($query) {
                $query->where('promotype', '>=', 1);
            })
            ->count();

        //Most Popular Ads
        $popular_ads = Ad::where('user_id', Auth::user()->id)
            ->with(['description', 'resources', 'category.description', 'category.parent.description']) //<- Nested Load Category, and Parent Category
            ->join('ad_stats', 'ads.id', '=', 'ad_stats.ad_id')
            ->orderBy('ad_stats.hits', 'desc')
            ->take(10)
            ->get();

        $section_name = "Mi Panel de Anuncios";

        return view('user.home', compact('section_name', 'total_active_ads', 'total_promoted_ads', 'popular_ads'));
    }

    /** 
     * User Ads
     * Here:
     * paginate
     * Order By
     * Group By
     */
    public function ads(Request $request)
    {
        //SEO Data
        $seo_data = [
            'title' => "Mis anuncios en Bachecubano",
            'desc' => "Análisis de estadísticas y gestión de mi perfil en Bachecubano",
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');

        //Total active ads
        $total_active_ads = Auth::user()->ads->count();

        $section_name = "Mis Anuncios";

        //post Per Page Custom configuration
        $posts_per_page = AdController::post_per_page($request);

        //Customize pagination
        //You may append to the query string of pagination links using the appends method. For example, to append sort=votes to each pagination link, you should make the following call to appends:
        //{{ $users->appends(['sort' => 'votes'])->links() }}

        $my_ads = Ad::where('user_id', Auth::user()->id)
            ->with(['description', 'resources', 'category.description', 'category.parent.description']) //<- Nested Load Category, and Parent Category
            ->paginate($posts_per_page);

        return view('user.ads', compact('section_name', 'total_active_ads', 'my_ads'));
    }
}
