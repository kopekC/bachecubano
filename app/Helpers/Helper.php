<?php

if (!function_exists('ad_url')) {
    /**
     * Transforma un texto de tarjeta en una formateada por espacios y/o ofscada
     */
    function ad_url($ad)
    {
        return route('show_ad', ['category' => $ad->category->parent->description->slug, 'subcategory' => $ad->category->description->slug, 'ad_title' => Str::slug($ad->description->title), 'id' => $ad->id]);
    }
}

if (!function_exists('ad_first_image')) {
    /**
     * Transforma un texto de tarjeta en una formateada por espacios y/o ofscada
     */
    function ad_first_image($ad)
    {
        if (isset($ad->resources[0]->name) && isset($ad->resources[0]->extension)) {
            return config('app.img_url') . $ad->resources[0]->name . "." . $ad->resources[0]->extension;
        } else {
            return config('app.img_url') . "android-chrome-192x192.png";
        }
    }
}

if (!function_exists('ad_price')) {
    /**
     * Transforma un texto de tarjeta en una formateada por espacios y/o ofscada
     */
    function ad_price($ad)
    {
        if ($ad->price > 0 && $ad->price != null) {
            return "$ " . $ad->price / 1000000;
        }
        return "";
    }
}
