<?php
    return [
        'maintenance-token' => env('MAINTENANCE_TOKEN'),
        'version' => '1.8',
        'discord' => 'https://discord.gg/FyNsM5k',
        'submit-tutorial' => 'https://forms.gle/ct4Yc75W4zjbR6Xi7',
        'flag-address' => env('FLAG_ADDRESS'),

        'homepage' => [
            'fits' => [
                'count' => 8
            ]
        ],

        'search' => [
            'link_save_time_days' => 7
        ],

        'cargo' => [
            'saveTime' => 60
        ],

        'items' => [
            'group_whitelist' => [1992,1993,105,255,2019,1964,1088,1990,257,1995,1977,1979,1996,489,107,106,487,4050],
            'items_blacklist' => [940, 32877]
        ],

        'scoped' => [
            'client_id'     => env('EVEONLINE_SCOPED_CLIENT_ID'),
            'client_secret' => env('EVEONLINE_SCOPED_CLIENT_SECRET'),
            'redirect'      => env('EVEONLINE_SCOPED_REDIRECT'),
            'client_scopes' => env('EVEONLINE_SCOPED_CLIENT_SCOPES'),
        ],

        'mail-scope' => [
            'client_id'     => env('EVEONLINE_MAIL_SCOPED_CLIENT_ID'),
            'client_secret' => env('EVEONLINE_MAIL_SCOPED_CLIENT_SECRET'),
            'redirect'      => env('EVEONLINE_MAIL_SCOPED_REDIRECT'),
            'client_scopes' => env('EVEONLINE_MAIL_SCOPED_CLIENT_SCOPES'),
        ],

        'donation-scope' => [
            'client_id' => env("EVEONLINE_DONATION_SCOPED_CLIENT_ID"),
            'client_secret' => env("EVEONLINE_DONATION_SCOPED_CLIENT_SECRET"),
        ],

        'default-esi' => [
            'client_id' => env("EVEONLINE_CLIENT_ID"),
            'client_secret' => env("EVEONLINE_CLIENT_SECRET"),
            'redirect'      => env('EVEONLINE_REDIRECT'),
        ],

        'veetor' => [
            'id' => env("ID_VEETOR"),
            'refresh-token' => env("RT_VEETOR"),
        ],

        'market' => [
            'jita-id' => 60003760,
            'fuzzwork-api-root' => env('FUZZWORK_API_ROOT'),
            'eveworkbench' => [
                'service-root' => env('EVEWORKBENCH_API_ROOT'),
                'app-key' =>env('EVEWORKBENCH_API_APP_KEY'),
                'client-id' =>env('EVEWORKBENCH_API_CLIENT_ID'),
            ],

            'estimators' => [
                'single-item' => [
                    'App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\Impl\CacheSingleItemEstimator',
                    'App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\Impl\ItemPriceTableSingleItemEstimator',
                    'App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\Impl\FuzzworkMarketDataSingleItemEstimator',
                    'App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\Impl\EveWorkbenchSingleItemEstimator'
                ],
                'bulk' => [
                    'App\Http\Controllers\Loot\ValueEstimator\BulkItemEstimator\Impl\FuzzworkMarketDataBulkEstimator'
                ]
            ]
        ],

        'esi' => [
            'api-root' => env("ESI_ROOT", "https://esi.evetech.net/latest/"),
            'useragent' => env("ESI_USERAGENT", "Abyss Tracker (https://abyss.eve-nt.uk; molbal@outlook.com)"),
        ],

        'constants' => [
            'bonus-room' => "T5-BONUS"
        ],

        'verification' => [
            'zkillboard' => '/https?:\/\/zkillboard\.com\/kill\/\d+\/?$/m',
            'eveworkbench' => '/https?:\/\/(www.)?eveworkbench.com\/fitting\/[a-z \-]+\/[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}\/?$/m'
        ],

        'fit' => [
            'logs' => [
                'initial-date' => "2020-11-03"
            ],

            'patch-status' => [
                'works' => "success",
                'untested' => "warning",
                'deprecated' => "danger"
            ]
        ],

        'historic-loot' => [
            'from' => "2020-02-01"
        ],

        'accountant' => [
            'char-id' => env('ACCOUNTANT_CHAR_ID', 2117658503)
        ]
    ];
