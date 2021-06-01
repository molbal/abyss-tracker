<?php
return [
    'service-url' => env('FIT_SERVICE_URL'),
    'auth' => [
        'id'  => env('FIT_SERVICE_APP_ID'),
        'secret' => env('FIT_SERVICE_APP_SECRET'),
    ],

    'prefix' => [
        'default' => 'at',
        'pvp' => 'pvp'
    ]
];
