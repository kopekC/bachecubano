<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Api listener for rating Ads from user Class
 */
class RateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Rate Ad form numbers between 0 and 5, even decimals
     */
    public function rate(Request $request, Ad $ad, $rating)
    {
        $user = Auth::guard('api')->user();

        //If rating is valid amount between 0 and 5
        if ($rating >= 0 && $rating <= 5) {
            $user->rate($ad, $rating);
            return response()->json(['message' => 'Ad ' . $ad->id . ' rated', 'status' => 200], 200);
        }

        return response()->json(['message' => 'Nos valid rating value', 'status' => 404], 404);
    }
}
