<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\Ad;

use Illuminate\Support\Facades\Cache;

use Spatie\Searchable\Search;
use App\AdDescription;
use App\Post;
use App\Http\Controllers\AdController;

class AdsController extends Controller
{
    /**
     * Get All Right Now Categories
     * https://www.bachecubano.com/api/1.0/categories
     * or
     * httas://api.bachecubano.com/1.0/categories
     */
    public function get_categories()
    {
        $categories = Cache::rememberForever('cached_categories', function () {
            return Category::with(['description', 'stats', 'parent', 'childs'])->get();
        });
        return response()->json($categories);
    }

    /**
     * Get Ads for specific Category
     * https://www.bachecubano.com/api/1.0/ads/104
     * or
     * httas://api.bachecubano.com/1.0/ads/104
     */
    public function get_ads(Request $request, $category_id)
    {
        $ads = Cache::remember('cached_ads_' . $category_id, 60, function () use ($request, $category_id) {
            $ads = AdController::getAds($request, $category_id);
            return $ads;
        });

        return response()->json($ads);
    }

    /**
     * View Specific Ad Data
     */
    public function get_ad($ad_id)
    {
        $ad = Cache::remember('ad_' . $ad_id, 60, function () use ($ad_id) {
            $query = Ad::query();
            $query->with(['description', 'resources', 'stats', 'owner']);
            $ad = $query->findOrFail($ad_id);
            return $ad;
        });

        return response()->json($ad);
    }

    /**
     * Search Ad API
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('query');

        $query = Ad::query();

        $query->join('ad_descriptions', 'ads.id', '=', 'ad_descriptions.ad_id');

        //Select All elements
        $query->select('ads.id', 'ads.user_id', 'ads.category_id', 'ads.updated_at', 'ads.price', 'ads.contact_name', 'ad_descriptions.title', 'ad_descriptions.description');

        //Activated parameters
        $query->where('active', 1);
        $query->where('enabled', 1);

        /*
        $query->whereHas('tableB', function ($query) {
            // Now querying on tableB
            $query->where('fieldB', $valueB);
        })->orderBy('created_at', 'DESC');
        */

        $query->where('ad_descriptions.title', 'LIKE', "%{$searchTerm}%");
        $query->orWhere('ad_descriptions.description', 'LIKE', "%{$searchTerm}%");

        $query->latest();

        //Paginate all this
        $searchResults = $query->paginate(50);

        return response()->json($searchResults);
    }
}
