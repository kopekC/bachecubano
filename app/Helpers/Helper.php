<?php

//Constructed ad url
if (!function_exists('ad_url')) {
    /**
     * Transforma un texto de tarjeta en una formateada por espacios y/o ofscada
     */
    function ad_url($ad)
    {
        return route('show_ad', ['category' => $ad->category->parent->description->slug, 'subcategory' => $ad->category->description->slug, 'ad_title' => Str::slug($ad->description->title), 'id' => $ad->id]);
    }
}

//Show forst image assets url
if (!function_exists('ad_first_image')) {
    /**
     * Transforma un texto de tarjeta en una formateada por espacios y/o ofscada
     */
    function ad_first_image($ad)
    {
        if (isset($ad->resources[0]->id) && isset($ad->resources[0]->extension)) {
            return config('app.img_url') . $ad->resources[0]->path . $ad->resources[0]->id . "." . $ad->resources[0]->extension;
        } else {
            return asset("android-chrome-512x512.png");
        }
    }
}

//Show Ad Price id it exists
if (!function_exists('ad_price')) {
    /**
     * Transforma un texto de tarjeta en una formateada por espacios y/o ofscada
     */
    function ad_price($ad)
    {
        if ($ad->price > 0 && $ad->price != null) {
            return "$ " . $ad->price;
        }
        return "";
    }
}

//Category Getter
if (!function_exists('ad_category_url')) {
    /**
     * Transforma un texto de tarjeta en una formateada por espacios y/o ofscada
     */
    function ad_category_url($ad)
    {
        return config('app.url') . $ad->category->parent->description->slug . "/" . $ad->category->description->slug . "/";
    }
}

//Promotion Type
if (!function_exists('ad_promotion_text_type')) {
    /**
     * Transforma un texto de tarjeta en una formateada por espacios y/o ofscada
     */
    function ad_promotion_text_type($ad)
    {
        $promo_types = [
            1 => 'elbache',
            2 => 'plata',
            3 => 'oro',
            4 => 'diamante',
        ];

        return $promo_types[$ad->promo->promotype];
    }
}

//Sanitize description elements
if (!function_exists('text_clean')) {
    /**
     * Transforma un texto de tarjeta en una formateada por espacios y/o ofscada
     */
    function text_clean($str)
    {
        // Remove all characters except A-Z, a-z, 0-9, dots, hyphens and spaces
        // Note that the hyphen must go last not to be confused with a range (A-Z)
        // and the dot, being special, is escaped with \
        $str = preg_replace('/[^A-Za-z0-9\. -]/', '', $str);

        return $str;
    }
}
