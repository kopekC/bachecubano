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
        /**
         * <ul class="share-buttons">
         * <li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.bachecubano.com&quote=Bachecuano%20Short" target="_blank" title="Share on Facebook">Facebook</a></li>
         * <li><a href="https://twitter.com/intent/tweet?source=https%3A%2F%2Fwww.bachecubano.com&text=Bachecuano%20Short:%20https%3A%2F%2Fwww.bachecubano.com&via=Bachecubano" target="_blank" title="Tweet">Twitter</a></li>
         * <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=https%3A%2F%2Fwww.bachecubano.com&title=Bachecuano%20Short&summary=adsasdasadsas%20asdasdasd&source=https%3A%2F%2Fwww.bachecubano.com" target="_blank" title="Share on LinkedIn">LinkedIn</a></li>
         * <li><a href="mailto:?subject=Bachecuano%20Short&body=adsasdasadsas%20asdasdasd:%20https%3A%2F%2Fwww.bachecubano.com" target="_blank" title="Send email">Send email</a></li>
         * </ul>
         */

         //Find Out How to track this!!!

        switch ($network) {
            case "facebook":
                return redirect("https://www.facebook.com/sharer/sharer.php?u=" . base64_decode($url) . "&quote=" . base64_decode($text));
                break;

            case "twitter":
                return redirect("https://twitter.com/intent/tweet?source=" . base64_decode($url) . "&text=" . base64_decode($text) . ":%20https%3A%2F%2Fwww.bachecubano.com&via=Bachecubano");
                break;

            case "linkedin":
                return redirect("http://www.linkedin.com/shareArticle?mini=true&url=" . base64_decode($url) . "&title=" . base64_decode($text) . "&source=https%3A%2F%2Fwww.bachecubano.com");
                break;
        }
    }
}
