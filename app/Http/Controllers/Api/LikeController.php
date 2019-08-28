<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Ad;

/**
 * Api rest listener for LIKE/DISLIKE Behavior
 * 
 * API Class:
 * 
 * $user = User::find(1);
 * $post = Post::find(2);
 * $user->like($post);
 * $user->unlike($post);
 * $user->toggleLike($post);
 * $user->hasLiked($post); 
 * $post->isLikedBy($user); 
 * 
 */
class LikeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        //dump(Auth::check());                  true
        //dump($ad);                            Ad object
        //dump(Auth::guard('api')->user());     User object
    }

    /**
     * Hit like on Ad
     */
    public function ad_like(Request $request, Ad $ad)
    {
        $user = Auth::guard('api')->user();
        $user->like($ad);
        return response()->json(['message' => 'Ad ' . $ad->id . ' liked', 'status' => 200], 200);
    }

    /**
     * Dislike Ad
     */
    public function ad_dislike(Request $request, Ad $ad)
    {
        $user = Auth::guard('api')->user();
        $user->unlike($ad);

        return response()->json(['message' => 'Ad ' . $ad->id . ' disliked', 'status' => 200], 200);
    }

    /**
     * Like if no liked, Dislike if liked
     */
    public function ad_hit_like(Request $request, Ad $ad)
    {
        //Toggle way
        $user = Auth::guard('api')->user();
        $user->toggleLike($ad);

        return response()->json(['message' => 'Ad ' . $ad->id . ' hit', 'status' => 201], 200);
    }
}
