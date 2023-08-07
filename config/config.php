<?php

use App\Core\Roots;
use Kirby\Cms\Page;

return [
    'debug' => true,

    'cache' => [
        'pages' => [
            'active' => true,
            'type'   => 'static',
            'prefix' => 'pages',
        ]
    ],

    'panel' => [
        'css' => 'assets/css/custom-panel.css',
        'headline' => 'small',
    ],

    'db' => [
        'type'     => 'sqlite',
        'database' => Roots::DATABASE . '/data.sqlite',
    ],
    'eloquent' => [
        'driver'    => 'sqlite',
        'database' => Roots::DATABASE . '/data.sqlite',
        'prefix' => '',
    ],

    'api' => [
        'allowInsecure' => true,
        'basicAuth' => true
    ]

];
