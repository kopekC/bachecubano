<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function create()
    {
        SitemapGenerator::create('https://example.com')->writeToFile($path);
    }
}
