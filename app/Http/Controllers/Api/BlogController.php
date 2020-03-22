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

        //Send to Facebook

        //Send to ...

        //Send to ...

        //Facebook Instant Articles

        //Telegram Instant View

        //
    }
}
