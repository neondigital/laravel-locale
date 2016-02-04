<?php

return [

    'default' => 'uk',

    'country_detection' => true,   // From IP database

    'language_detection' => true,  // From browser headers

    'remember_locale' => true,     // Remember chosen locale in cookie

    'locales' => [

        'uk' => [
            'name' => 'United Kingdom',
            'language_code' => 'en',
            'country_code' => 'GB',
            'flag' => 'gb',
            'group' => 'europe',
        ],

        'ca-en' => [
            'name' => 'Canada (English)',
            'language_code' => 'en',
            'country_code' => 'CA',
            'flag' => 'ca',
            'alternatives' => ['ca-fr' => 'Français']
        ],

        'ca-fr' => [
            'name' => 'Canada (Français)',
            'language_code' => 'fr',
            'country_code' => 'CA',
            'flag' => 'ca',
            'alternatives' => ['ca-en' => 'English']
        ],

    ],

    'redirects' => [
        'ca' => 'ca-en',
    ],

];
