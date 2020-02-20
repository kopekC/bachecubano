<?php

use App\User;

//Constructed ad url
if (!function_exists('ad_url')) {
    /**
     * Obtiene la URL de un anuncio pasando el $ad object
     */
    function ad_url($ad)
    {
        //return route('show_ad', ['category' => $ad->category->parent->description->slug, 'subcategory' => $ad->category->description->slug, 'ad_title' => Str::slug($ad->description->title), 'ad_id' => $ad->id]);
        return config('app.url') . $ad->category->parent->description->slug . DIRECTORY_SEPARATOR . $ad->category->description->slug . DIRECTORY_SEPARATOR . Str::slug($ad->description->title) . DIRECTORY_SEPARATOR . $ad->id;
    }
}

/**
 * Show first image assets url
 */
if (!function_exists('ad_first_image')) {
    /**
     * Obtiene la primera imagen de un anuncio, pasa el segundo parametro como la calidad del mismo
     * Qualyties: [original, preview, thumbnail]
     */
    function ad_first_image($ad, $quality = 'thumbnail')
    {
        if (isset($ad->resources[0]->id) && isset($ad->resources[0]->extension)) {
            return config('app.img_url') . $ad->resources[0]->path . $ad->resources[0]->id . "_" . $quality . "." . $ad->resources[0]->extension;
        } else {
            return asset("android-chrome-512x512.png");
        }
    }
}

/**
 * Show first phisical image asset url
 */
if (!function_exists('ad_first_physical_image')) {
    /**
     * Obtiene la primera imagen de un anuncio, pasa el segundo parametro como la calidad del mismo
     * Qualyties: [original, preview, thumbnail]
     */
    function ad_first_physical_image($ad, $quality = 'thumbnail')
    {
        if (isset($ad->resources[0]->id) && isset($ad->resources[0]->extension)) {
            return public_path('images') . DIRECTORY_SEPARATOR . $ad->resources[0]->path . $ad->resources[0]->id . "_" . $quality . "." . $ad->resources[0]->extension;
        } else {
            return asset("android-chrome-512x512.png");
        }
    }
}

/**
 * Shortcut to first Image
 */
if (!function_exists('ad_image_url')) {
    /**
     * Obten la url construida de un recurso de anuncios
     */
    function ad_image_url($ad_resource_intance, $quality = 'thumbnail')
    {
        return config('app.img_url') . $ad_resource_intance->path . $ad_resource_intance->id  . "_" . $quality . "." . $ad_resource_intance->extension;
    }
}

//Show Ad Price id it exists
if (!function_exists('ad_price')) {
    /**
     * Obtiene el precio establec o no de un anuncio
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
     * Obtiene la categoria URL de un anuncio
     */
    function ad_category_url($ad)
    {
        return config('app.url') . $ad->category->parent->description->slug . "/" . $ad->category->description->slug . "/";
    }
}

//Promotion Type
if (!function_exists('ad_promotion_text_type')) {
    /**
     * Obtiene el tipo de promocion de un anuncio basado en el promotype
     */
    function ad_promotion_text_type($ad)
    {
        $promo_types = [
            0 => "Gratis",
            1 => 'Elbache',
            2 => 'Plata',
            3 => 'Oro',
            4 => 'Diamante',
            5 => 'Youtube',
            6 => 'Partner'
        ];

        if (!isset($ad->promotype)) {
            return "Diamante";
        } else {
            return $promo_types[$ad->promotype];
        }
    }
}

//Promotion Type
if (!function_exists('ad_promotion_color_type')) {
    /**
     * Obtiene el tipo de promocion de un anuncio basado en el promotype
     */
    function ad_promotion_color_type($ad)
    {
        $promo_types = [
            0 => "white",
            1 => 'gray',
            2 => 'mandarina',
            3 => 'yellow',
            4 => 'blue',
            5 => 'red',
            6 => 'scrolling'
        ];

        if (!isset($ad->promotype)) {
            return "white";
        } else {
            return $promo_types[$ad->promotype];
        }
    }
}

//Sanitize description elements
if (!function_exists('text_clean')) {
    /**
     * Limpia el texto para uso en etiquetas SEO
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


//Get Profile image route
if (!function_exists('profile_logo')) {
    /**
     * Limpia el texto para uso en etiquetas SEO
     */
    function profile_logo(User $user)
    {
        if (!is_null($user->profile_picture) && $user->profile_picture != "") {
            return config('app.img_url') . "uploads/" . $user->id . "/" . $user->profile_picture;
        }
        return asset('android-chrome-192x192.png');
    }
}
