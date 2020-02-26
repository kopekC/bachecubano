<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class DefaultLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //URL::defaults(['province_slug' => $request->user()->province_slug]);
        //URL::defaults(['province_slug' => "www"]);
        URL::defaults(['province_slug' => isset($request->province_slug) ? $request->province_slug : "www"]);
        return $next($request);
    }
}
