<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ad;
use App\User;

class MailableController extends Controller
{
    public function view() {
        
        $ad = Ad::find(23);
        $user_data = User::find(23);

        //Mail::to("ecruz@bachecubano.com")->send(new AdPublished($ad, $user_data));
        return new App\Mail\AdPublished($ad, $user_data);
    }
}
