<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\Ad;

use Illuminate\Support\Facades\Cache;

use App\AdDescription;
use App\Post;
use App\Http\Controllers\AdController;

class AdsController extends Controller
{
    /**
     * Get All Right Now Categories
     * https://api.bachecubano.com/v1/categories
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
     * https://api.bachecubano.com/v1/ads/104
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
}
