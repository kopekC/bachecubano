<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Ad;


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
    }

    public function like(Request $request, Ad $ad)
    {
        dump(Auth::check());
        dump($ad);
        dump(Auth::guard('api')->user());
        //dd($user);
    }

    public function dislike(Request $request, Ad $ad)
    { }
}
