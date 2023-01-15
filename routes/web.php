<?php


use App\Controllers\AdminController;
use App\Core\Dispatch;

return   [
    [
        'pattern' =>  'admin/(:any)',
        'action' => function ($action) {
            Dispatch::actionController(AdminController::class, $action);
        }
    ],

];




