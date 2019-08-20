<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MailableController extends Controller
{
    public function view() {
        $ad = App\Ad::find(23);
        $user_data = App\User::find(23);
        //Mail::to("ecruz@bachecubano.com")->send(new AdPublished($ad, $user_data));
        return new App\Mail\AdPublished($ad, $user_data);
    }
}
