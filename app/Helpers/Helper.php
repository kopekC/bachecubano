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
