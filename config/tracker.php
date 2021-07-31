<?php
    return [
        'maintenance-token' => env('MAINTENANCE_TOKEN'),
        'version' => '1.10.5',
        'fileversion' => '110',
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
            'items_blacklist' => [940, 32877, 27361]
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
            'invite-link' => 'https://www.eveonline.com/signup?invc=3fbe9153-83c9-4130-b47c-358d364a9be0'
        ],

        'market' => [
            'jita-id' => 60003760,
            'fuzzwork-api-root' => env('FUZZWORK_API_ROOT'),
            'eveworkbench' => [
                'service-root' => env('EVEWORKBENCH_API_ROOT'),
                'app-key' =>env('EVEWORKBENCH_API_APP_KEY'),
                'client-id' =>env('EVEWORKBENCH_API_CLIENT_ID'),
            ],

            'janice' => [
                'service-root'=> env('JANICE_API_ROOT', "https://janice.e-351.com/api/rest/v1/"),
                'app-key' => env('JANICE_APP_KEY')
            ],

            'estimators' => [
                'single-item' => [
//                    'App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\Impl\CacheSingleItemEstimator',
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
            'eveworkbench' => '/https?:\/\/(www.)?eveworkbench.com\/fitting\/[a-z \-]+\/[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}\/?$/m',
            'youtube' => '/https?:\/\/(www\.)?(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)/',
        ],

        'fit' => [
            'logs' => [
                'initial-date' => "2020-11-03"
            ],

            'patch-status' => [
                'works' => "success",
                'untested' => "warning",
                'deprecated' => "danger"
            ],
        ],

        'historic-loot' => [
            'from' => "2020-02-01"
        ],

        'accountant' => [
            'char-id' => env('ACCOUNTANT_CHAR_ID', 2117658503)
        ],

        'pvp' => [
            'bridge-passcode' => env('BRIDGE_PASSCODE'),
            'accept-ids' => [
                '1v1-battleship-arena' => [638,639,640,641,642,643,644,645,24688,24690,24692,24694,47466],
                '2v2v2-gallente-cruisers-and-assault-frigates' => [627, 626, 633, 12044, 12042],
                'liberation-games-rifter-ffa' => [587],
                'proving-conduit-throwback' => [2836,11969,17922,11993,33675,20125,17720,12023,12011,44995,11957,17715,11961,52252,12005,11971,32209,33395,12015,33818,17718,11965,11963,11959,12019,54732,33470,48635,11999,3518,47270,45531,17722,12003],
            ]
        ],

        'meili' => [
            'endpoint' => env('MEILI_ENDPOINT', 'http://127.0.0.1:7700'),
            'masterKey' => env('MEILI_MASTER', null),
        ]
    ];
