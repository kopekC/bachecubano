<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "Bachecubano", // set false to total remove
            'description'  => 'Web de negocios, tiendas y clasificados en Cuba. Especialidad en computadoras, celulares, accesorios, electrodomésticos, casas, carros y compras online.', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => ['clasificados cuba', 'compra venta cuba', 'tiendas online cuba', 'ecommerce cuba', 'amazon cuba', 'revolico cuba', 'porlalivre cuba', 'compras online cuba'],
            'canonical'    => null, // Set null for using Url::current(), set false to total remove
            'robots'       => 'all', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Bachecubano', // set false to total remove
            'description' => 'Web de negocios, tiendas y clasificados en Cuba. Especialidad en computadoras, celulares, accesorios, electrodomésticos, casas, carros y compras online.', // set false to total remove
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => 'Bachecubano',
            'images'      => [],
            'locale'      => 'es_ES',     
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'summary',
            'site'        => '@Bachecubano',
        ],
    ],
];
