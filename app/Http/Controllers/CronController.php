<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        //Dtelete all promo entries prevois to today
    }

    /**
     * Tree day earlier, notifi all ending promos
     */
    public function notify_ending_promos()
    {
    }

    
}
