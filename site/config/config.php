<?php

use Kirby\Cms\Page;

return [
    'debug' => true,
    'routes' => require __DIR__ . '/routes.php',
    'pages' =>  require __DIR__ . '/pages.php',
    'pageMethods' => [
        'linktag' => function () {
            return '<a href="' . $this->url() . '">' . $this->title()->html() . '</a>';
        },
        'hasParents' => function() {
            return $this->parents()->count();
        }
    ],

];
