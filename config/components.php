<?php

return [
    'namespaces' => [
        'filament' => 'Filament\\Forms\\Components\\',
        'tables' => 'Filament\\Tables\\Components\\',
        'infolists' => 'Filament\\Infolists\\Components\\',
    ],

    'default_view_path' => 'components.filament-dynamic',

    'cache_components' => env('CACHE_COMPONENTS', true),
];
