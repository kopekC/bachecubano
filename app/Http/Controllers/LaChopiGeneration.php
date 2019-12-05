<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class for LaChopi DB Generation
 */
class LaChopiGeneration extends Controller
{

    public function __construct()
    {
        //begin benchmark, and some prior optimizations
    }

    public function generate() {
        //Get all category ID's


    }

    /**
     * Get alls ads from specifica category
     */
    public function getCategoryAds($category_id) {
        //This is called every category ID, so retrieve ads from it
        
    }
}
