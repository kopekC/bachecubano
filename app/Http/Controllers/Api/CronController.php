<?php

namespace App\Http\Controllers\Api;

use App\Ad;
use App\AdPromo;
use App\AdResource;
use App\Http\Controllers\Controller;
use App\Mail\PromoEnding;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CronController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Delete all older promotions
     */
    public function delete_old_promotions()
    {
        //Now Dates
        //Dtelete all promo entries previous to today
        $today = Carbon::today();
        $deletedRows = AdPromo::where('end_promo', '<', $today)->delete();

        echo $deletedRows . " promotions deleted";
    }

    /**
     * Tree day earlier, notifi all ending promos
     */
    public function notify_ending_promos()
    {
        //Get all promos ending in three days
        $today = Carbon::today();
        $next_3_days = $today->addDays(3);

        $next_ending_promos = AdPromo::where('end_promo', '=', $next_3_days)->with(['ad', 'ad.owner', 'ad.description'])->get();

        if ($next_ending_promos->count() > 0) {
            $i = 0;
            foreach ($next_ending_promos as $ending_promo_ad) {
                //Title: $ending_promo_ad->ad->description->title;
                //Email: $ending_promo_ad->ad->owner->email;
                //Email: $ending_promo_ad->ad->owner->name;
                Mail::to($ending_promo_ad->ad->owner->email)->send(new PromoEnding($ending_promo_ad->ad->owner->name, $ending_promo_ad->ad->description->title));
                $i++;
            }
            echo "Sent emails: " . $i;
        } else {
            echo "No hay promociones en vencimiento";
        }
    }

    /**
     * Set far futere updated dates for promoted ads
     */
    public function update_promoted_ads()
    {
        $now = Carbon::now();
        $more1 = $now->addDay();

        $now = Carbon::now();
        $more2 = $now->addDays(2);

        $now = Carbon::now();
        $more3 = $now->addDays(3);

        $now = Carbon::now();
        $more4 = $now->addDays(4);

        //Get Promoted Ads and its promotype
        $promoted_ads = Ad::with(['promo']) //<- Nested Load Category, and Parent Category
            ->whereHas('promo', function ($query) {
                $query->where('promotype', '>=', 1);
            })->get();

        //Iterate and update ads with a far future days
        foreach ($promoted_ads as $promoted_ad) {
            if ($promoted_ad->promo->promotype == 1) {
                $promoted_ad->updated_at = $more1;
            } elseif ($promoted_ad->promo->promotype == 2) {
                $promoted_ad->updated_at = $more2;
            } elseif ($promoted_ad->promo->promotype == 3) {
                $promoted_ad->updated_at = $more3;
            } elseif ($promoted_ad->promo->promotype == 4) {
                $promoted_ad->updated_at = $more4;
            }
            $promoted_ad->update();
        }
    }

    /**
     * Just Delete unused images for database cleanup
     */
    public function delete_unused_images()
    {
        //Get All non linked images
        //delete phisically version of them!
        //Do this at midnight
        $unlinked_images = AdResource::where('',)->limit(300)->get();
    }
}
