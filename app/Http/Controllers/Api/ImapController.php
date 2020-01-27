<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImapController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Zapier Webhook on imap post email
     */
    public function zapier_hook(Request $request)
    {
        //From
        $from = $request->input('from');
        //Header
        $header = $request->input('header');
        //Body
        $body = $request->input('body');

        dump($from);
        dump($header);
        dump($body);
    }
}
