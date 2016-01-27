<?php

return [

    'default' => 'gb',

    'country_detection' => true,   // From IP database

    'language_detection' => true,  // From browser headers

    'remember_locale' => true,     // Remember chosen locale in cookie

    'locales' => [

        'gb' => [
            'name' => 'Great Britain',
            'language_code' => 'en',
            'country_code' => 'GB',
            'group' => 'europe',
        ],

        'ca-en' => [
            'name' => 'Canada (English)',
            'language_code' => 'en',
            'country_code' => 'CA',
        ],

        'ca-fr' => [
            'name' => 'Canada (Français)',
            'language_code' => 'fr',
            'country_code' => 'CA',
        ],

    ],

    'redirects' => [
        'ca' => 'ca-en',
    ],

];
