<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class FollowController extends Controller
{
    /**
     * Follow this User for later notifications and offers
     */
    public function follow(Request $request, User $follow_to)
    {
        $me = Auth::guard('api')->user();
        $me->follow($follow_to);

        return response()->json(['message' => 'Followed ' . $follow_to->id, 'status' => 200], 200);
    }

    /**
     * Unfollow User
     */
    public function unfollow(Request $request, User $unfollow_to)
    {
        $me = Auth::guard('api')->user();
        $me->unfollow($unfollow_to);

        return response()->json(['message' => 'UnFollowed ' . $unfollow_to->id, 'status' => 200], 200);
    }
}
