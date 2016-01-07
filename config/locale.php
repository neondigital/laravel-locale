<?php

return [

    'default' => 'gb',

    'country_detection' => true,   // From IP database

    'language_detection' => true,  // From browser headers

    'remember_locale' => true,     // Remember chosen locale in cookie

    'locales' => [

        'gb' => [
            'name' => 'Great Britain',
            'language_code' => 'en-GB',
            'group' => 'europe',
        ],

        'za' => [
            'name' => 'South Africa',
            'language_code' => 'en-ZA',
        ],

        'us' => [
            'name' => 'United States',
            'language_code' => 'en-US',
        ],

        'ca-en' => [
            'name' => 'Canada (English)',
            'country_code' => 'ca',
            'language_code' => 'en-CA',
        ],

        'ca-fr' => [
            'name' => 'Canada (Français)',
            'country_code' => 'ca',
            'language_code' => 'fr-CA',
        ],

        'be-nl' => [
            'name' => 'België',
            'country_code' => 'be',
            'language_code' => 'nl-BE',
            'group' => 'europe',
        ],

        'be-fr' => [
            'name' => 'Belgique',
            'country_code' => 'be',
            'language_code' => 'fr-BE',
            'group' => 'europe',
        ],

    ],

    'redirects' => [
        'ca' => 'ca-en',
        'be' => 'be-fr',
    ],

];
