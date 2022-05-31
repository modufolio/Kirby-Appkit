<?php


use App\Core\Dispatch;

return   [
    [
        'pattern' => '/basic/(:any)',
        'action'  => function($method) {
            return Dispatch::actionController('Basic',$method);
        }
    ],

];




