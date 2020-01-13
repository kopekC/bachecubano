<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Welcome API endpoints with some resources
     * Dinamize this?
     */
    public function index(Request $request) {

        $help_resources = [
            'home' => config('app.url'),
            'docs' => 'https://api.bachecubano.com/docs'
        ];

        return response()->json($help_resources);
    }
}
