<?php

namespace App\Http\Controllers;

use App\Category;
use App\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use SEOMeta;
use OpenGraph;
use Twitter;

use App\CategoryDescription;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cookie;

//use Illuminate\Support\Facades\URL;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category, $subcategory = "")
    {
        //Get Super and SubCategory
        $super_category = CategoryDescription::where('slug', $category)->first();
        $sub_category =  CategoryDescription::where('slug', $subcategory)->first();

        if ($sub_category != "") {
            $seo_data = [
                'title' => $sub_category->name,
                'desc' => $sub_category->description,
            ];
        } else {
            $seo_data = [
                'title' => $super_category->name,
                'desc' => $super_category->description,
            ];
        }
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');

        //Parametrice all Input elements and pass to corresponding method where
        //Getted from Input GET data

        //post Per Page Custom configuration
        $posts_per_page = $this->post_per_page($request);

        $query = Ad::query();

        //Select All elements
        $query->select('ads.*', 'ad_promos.promotype');

        //Category Condition if subcategory or Super Category
        if (isset($sub_category->category_id)) {
            $query->where('category_id', $sub_category->category_id);
        } else {
            $sub_categories = Category::where('parent_id', '=', $super_category->category_id)->select('id')->get();
            $query->whereIn('category_id', $sub_categories);
        }

        //With associated elements
        $query->with(['description', 'resources', 'category.description', 'category.parent.description']);

        //Join for a correct ordering?
        $query->leftjoin('ad_promos', 'ads.id', '=', 'ad_promos.ad_id');

        //Minimal Price
        if (null !== Input::get('min_price')) {
            $query->when(request('min_price') >= 0, function ($q) {
                return $q->where('price', '>=', request('min_price', 0));
            });
        }

        //Maximum Price
        if (null !== Input::get('max_price')) {
            $query->when(request('max_price') >= 0, function ($q) {
                return $q->where('price', '<=', request('max_price', 0));
            });
        }

        //Search Query With on;y Photos ads
        if (null !== Input::get('only_photos')) {
            $query->when(request('only_photos') == 1, function ($q) {
                return $q->whereHas('resources');
            });
        }

        //Order Bu PromoType and later as updated time
        $query->orderBy('ad_promos.promotype', 'desc');
        $query->latest();

        //Activated parameters
        $query->where('active', 1);
        $query->where('enabled', 1);

        //Paginate all this
        $ads = $query->paginate($posts_per_page);

        return view('ads.index', compact('ads', 'super_category', 'sub_category', 'posts_per_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //SEO Data
        $seo_data = [
            'title' => "Publicar anuncio gratis",
            'desc' => "Promociona tu producto, negocio o servicio en nuestra web GRATIS",
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');




        return view('ads.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $category, $subcategory, $ad_title, $ad_id)
    {
        //Retrieve Ad
        $ad = Ad::with(['description', 'resources', 'category.description', 'category.parent.description', 'stats'])->findOrFail($ad_id);

        //SEO Data
        $seo_data = [
            'title' => Str::limit($ad->description->title, 60),
            'desc' => text_clean(Str::limit($ad->description->description, 160)),
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');

        //Iterate every image for OpenGrap and Owl Carousell
        if (count($ad->resources) >= 1) {
            foreach ($ad->resources as $resource) {
                OpenGraph::addImage(ad_image_url($resource));
            }
        } else {
            OpenGraph::addImage(ad_first_image($ad));
        }

        //Featured Listing, Diamond and Gold Random
        $promoted_ads = Ad::where('active', 1)
            ->with(['description', 'resources', 'category.description', 'category.parent.description', 'promo']) //<- Nested Load Category, and Parent Category
            ->whereHas('promo', function ($query) {
                $query->where('promotype', '>=', 3);
            })
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('ads.show', compact('ad', 'promoted_ads'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Get Post per Page value
     */
    private function post_per_page($request)
    {
        /**
         * It means – let’s try to get posts_per_page from GET request, if it’s not there, then let’s default to the data in the Cookie.
         */
        $cookie_value = Cookie::get('posts_per_page');
        $posts_per_page = $request->get('posts_per_page', $cookie_value);

        /**
         * But what if there’s no Cookie? That’s the second block:
         * We save possible pagination values, and a default value in config file – in my case it’s config/constants.php:
         */
        $options = config('constants.posts_per_page_options');
        if (!$posts_per_page || !in_array($posts_per_page, $options)) {
            $posts_per_page = config('constants.posts_per_page_default');
        }

        /**
         * We save possible pagination values, and a default value in config file – in my case it’s config/constants.php
         * Finally, last line is just saving that value into the Cookie again, for the future requests.
         */

        Cookie::queue('posts_per_page', $posts_per_page);

        return $posts_per_page;
    }
}
