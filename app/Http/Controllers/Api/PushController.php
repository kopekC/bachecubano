<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Illuminate\Support\Str;

class PushController extends Controller
{
    /**
     * Push notification for certain Ad
     */
    public static function send_notification_promoted_ad($ad)
    {
        $data = [
            'name' => 'Promotion-' . $ad->id . '-' . Carbon::today(),
            'title' => Str::limit($ad->description->title, 69),
            'url' => ad_url($ad),
            'icon' => '',
            'message' => Str::limit($ad->description->description, 96) . " ...",
        ];

        $headers = [
            config('push.push_domain_header') => config('push.push_domain'),
            config('push.push_token_header') => config('push.push_token'),
        ];
        $client = new \GuzzleHttp\Client(['headers' => $headers]);

        $response = $client->request('POST', config('push.push_server'), ['form_params' => $data]);

        $rsp = $response->getBody()->getContents();

        return $rsp;
    }

    /**
     * Test method, now without any route
     */
    public static function send_notification($campaign_name, $title, $url, $message, $icon = '')
    {
        $data = [
            'name' => $campaign_name,
            'title' => $title,
            'url' => $url,
            'icon' => $icon,
            'message' => $message,
        ];

        $headers = [
            config('push.push_domain_header') => config('push.push_domain'),
            config('push.push_token_header') => config('push.push_token'),
        ];
        $client = new \GuzzleHttp\Client(['headers' => $headers]);

        $response = $client->request('POST', config('push.push_server'), ['form_params' => $data]);

        $rsp = $response->getBody()->getContents();

        dd($rsp);
    }
}
