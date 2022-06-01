<?php

return [
    'debug' => true,
    'routes' => require __DIR__ . '/routes.php',
    'pageMethods' => [
        'linktag' => function () {
            return '<a href="' . $this->url() . '">' . $this->title()->html() . '</a>';
        }
    ]
];
