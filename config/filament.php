<?php

return [
    'path' => 'admin',
    'domain' => null,
    'home_url' => '/admin',
    'layout' => [
        'navigation' => [
            'location' => 'sidebar',
        ],
    ],
    'colors' => [
        'primary' => [
            50 => '238, 242, 255',
            100 => '224, 231, 255',
            200 => '199, 210, 254',
            300 => '165, 180, 252',
            400 => '129, 140, 248',
            500 => '99, 102, 241',
            600 => '79, 70, 229',
            700 => '67, 56, 202',
            800 => '55, 48, 163',
            900 => '49, 46, 129',
            950 => '30, 27, 75',
        ],
    ],
    'middleware' => [
        'auth' => [
            \App\Http\Middleware\FilamentAccess::class,
        ],
    ],
    'auth' => [
        'guard' => env('FILAMENT_AUTH_GUARD', 'web'),
    ],
];
