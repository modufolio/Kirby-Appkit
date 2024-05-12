<?php

use App\Controllers\AdminController;
use App\Core\Roots;
use App\Http\RouteGenerator;
use Kirby\Cms\Page;

return [
    'debug' => env('APP_DEBUG', false),

    'cache' => [
        'pages' => [
            'active' => env('APP_CACHE', false),
            'type'   => 'static',
            'prefix' => 'pages',
            'ignore' => fn (\Kirby\Cms\Page $page) => $page->kirby()->user() !== null
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

    'routes' => (new RouteGenerator([
        AdminController::class
    ]))->getRoutes(),

    'api' => [
        'allowInsecure' => true,
        'basicAuth' => true
    ]

];
