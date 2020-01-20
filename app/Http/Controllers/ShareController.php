<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareController extends Controller
{
    /**
     * Sharing routes for a cleaning redirection even metrics
     */
    public function index(Request $request, $network, $url, $text)
    {

        //Find Out How to track this!!!
        //Google Analytics Calls for API https://github.com/irazasyed/laravel-gamp
        switch ($network) {
            case "facebook":
                return redirect("https://www.facebook.com/sharer/sharer.php?u=" . base64_decode($url) . "&quote=" . urlencode(base64_decode($text)));
                break;

            case "twitter":
                return redirect("https://twitter.com/intent/tweet?source=" . base64_decode($url) . "&text=" . urlencode(base64_decode($text)) . ":%20" . base64_decode($url) . "&via=Bachecubano");
                break;

            case "linkedin":
                return redirect("https://www.linkedin.com/shareArticle?mini=true&url=" . base64_decode($url) . "&title=" . urlencode(base64_decode($text)) . "&source=https%3A%2F%2Fwww.bachecubano.com");
                break;

            case "telegram":
                return redirect("https://telegram.me/share/url?url=" . base64_decode($url));
                break;
        }
    }


    //Show an Invite intercafe for Viralizae content like facebook, twitter, Email etc.
    public function invite($item, $misc)
    {
        //Iterate Over Diferent points
        return $item . $misc;
    }
}
