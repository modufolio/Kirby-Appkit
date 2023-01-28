<?php

// set up virtual pages as array
return [
    [
        'slug'     => 'login',
        'template' => 'login',
        'model'    => 'login',
        'content'  => [
            'uuid' =>  '874f489b-176e-4d7a-96d9-cd673ceef707',
            'title' => 'Login',
            'text'  => 'Some content here'
        ],
    ],
    [
        'slug'     => 'shop',
        'template' => 'shop',
        'model'    => 'shop',
        'content'  => [
            'uuid' =>  '12c4d5d2-4484-40bc-ac58-a2808c87f01a',
            'title' => 'Shop',
            'text'  => 'Some content here'
        ],
    ],
];