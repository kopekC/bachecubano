<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ad;

class LikeController extends Controller
{
    public function __construct()
    {
        
    }

    public function like(Request $request, Ad $ad) {
        $user = Auth::user()->id;
        dd($user);
    }

    public function dislike(Request $request, Ad $ad) {

    }
}
