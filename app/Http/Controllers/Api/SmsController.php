<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    /**
     * Securize thi endpoint
     */
    public function __construct()
    {
        //Initialize some security steps here?
    }

    /**
     * Get a SMS delivery request and preoccess it.
     * 
     * Typically a POST request with:
     * 
     */
    public function send_sms(Request $request)
    {
        
    }
}
