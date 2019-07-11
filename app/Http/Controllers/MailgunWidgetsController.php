<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailgunWidgetsController extends Controller
{
    public function store()
    {
        app('log')->debug(request()->all());
        return response()->json(['status' => 'ok']);
    }
}