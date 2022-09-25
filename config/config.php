<?php

use Kirby\Cms\Page;

return [
    'debug' => true,

    'db' => [
        'type'     => 'sqlite',
        'database' => BASE_DIR .'/database/data.sqlite' #full path to file
    ],

    'api' => [
        'allowInsecure' => true,
        'basicAuth' => true
    ]

];
