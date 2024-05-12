<?php

namespace App\Controllers;

use App\Http\RouteAttribute;

class AdminController
{
    #[RouteAttribute('/admin/login', ['GET'])]
    public function login()
    {
        $userid = env('USERID');
        $is_dev = env('APP_ENV') === 'local';
        $user = kirby()->user($userid);
        if ($is_dev && $user) {
            $user->loginPasswordless();
        }

        go('/panel');
    }
    #[RouteAttribute('/admin/logout', ['GET'])]
    public function logout()
    {
        if ($user = kirby()->user()) {
            $user->logout();
        }
        go('/');
    }
}
