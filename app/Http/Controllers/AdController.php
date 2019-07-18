<?php

namespace App\Http\Controllers;

use App\Category;
use App\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use SEOMeta;
use OpenGraph;
use Twitter;

//use Illuminate\Support\Facades\URL;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Here's come the Sun
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
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
        $ad = Ad::with(['description', 'resources', 'category.description', 'category.parent.description', 'promo', 'stats'])
            ->findOrFail($ad_id);

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
        if ($ad->resources != null) {
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
}
