<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\Ad;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;

class AdController extends Controller
{
    /**
     * Get All Right Now Categories
     * https://www.bachecubano.com/api/1.0/categories
     * or
     * httas://api.bachecubano.com/1.0/categories
     */
    public function get_categories()
    {
        $categories = Cache::remember('cached_categpories', 60 * 24 * 7, function () {
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

        $ads = Cache::remember('cached_ads_' . $category_id, 60, function () use ($category_id) {

            $query = Ad::query();

            //Select All elements
            $query->select('ads.id', 'ads.user_id', 'ads.category_id', 'ads.updated_at', 'ads.price', 'ads.contact_name', 'ad_promos.promotype');

            //Category Condition
            $query->where('category_id', $category_id);

            //With associated elements
            $query->with(['description', 'resources']);

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
            //Order By PromoType and later as updated time
            $query->orderBy('ad_promos.promotype', 'desc');
            $query->latest();

            //Activated parameters
            $query->where('active', 1);
            $query->where('enabled', 1);

            //Paginate all this
            return $query->paginate(50);
        });

        return response()->json($ads);
    }
}
