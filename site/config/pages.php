<?php

// set up virtual pages as array
return [
    [
        'slug'     => 'login',
        'template' => 'login',
        'model'    => 'login',
        'content'  => [
            'title' => 'Login',
            'text'  => 'Some content here'
        ],
    ],
    [
        'slug'     => 'shop',
        'template' => 'shop',
        'model'    => 'shop',
        'content'  => [
            'title' => 'Shop',
            'text'  => 'Some content here'
        ],
    ],
];