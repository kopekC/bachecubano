<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

/**
 * Some Blog moderation here
 */
class BlogController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Blog Post approve and viralice
     */
    public function approve_post($post_id)
    {
        //Some secured access here

        $blog_post = Post::findOrFail($post_id);
        dd($blog_post);

        if ($blog_post->approved == 1) {
            return response()->json(['message' => 'El artículo ya está aprobado', 'status' => 403], 403);
        }

        //Set approved
        $blog_post->update(['approved' => 1]);

        //Send to Twitter
        //Mention @ErichGarciaCruz and @natashatenorio

        //Send to Telegram
        //With iv parameters
        //https://t.me/share/url?url=https%3A%2F%2Ft.me%2Fiv%3Furl%3Dhttps%253A%252F%252Fwww.bachecubano.com%252Fblog%252Fnoticias-bachecubano%252Fcomenzaremos-a-pagar-y-monetizar-anuncios-seguidores%26rhash%3D0929b8713a7588


        //Send to Facebook

        //Send to ...

        //Send to ...

        //Facebook Instant Articles

        //Telegram Instant View

        //
    }
}
