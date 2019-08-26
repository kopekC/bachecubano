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

    public function like(Request $request, Ad $ad)
    {
        $user = Auth::guard('api')->user();
        $user->like($ad);
    }

    //Dislike Ad
    public function dislike(Request $request, Ad $ad)
    {
        $user = Auth::guard('api')->user();
        $user->unlike($ad);
    }

    //Like if no liked, Dislike if liked
    public function hit_like(Request $request, Ad $ad)
    {
        //Toggle way
        $user = Auth::guard('api')->user();
        $user->toggleLike($ad);
    }
}
