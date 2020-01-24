<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
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
        //Validate this input
        $request->validate([
            'phone' => 'bail|required|numeric',
            'message' => 'bail|required|min:1|max:150',
            'agree' => 'bail|required',
            'api_token' => 'bail|required'              //Retrieved as GET or POST?
        ]);

        dump($request->input('phone'));
        dump($request->input('message'));
        dump($request->input('api_token'));

        $user = (new User())->getByToken($request->input('api_token'));
        dd($user);
    }
}
