<?php

namespace App\Http\Controllers\Api;

use App\AdPromo;
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
     * Just Delete unused images for database cleanup
     */
    public function delete_unused_images()
    {
        
    }
}
