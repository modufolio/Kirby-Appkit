<?php

namespace App\Controllers;

class AdminController
{
    public function loginAction()
    {
        $userid = env('USERID');
        $is_dev = env('ENV') === 'dev';
        $user = kirby()->user($userid);
        if ($is_dev && $user) {
            $user->loginPasswordless();
        }

        go('/');
    }
    public function logoutAction()
    {
        if ($user = kirby()->user()) {
            $user->logout();
        }
        go('/');
    }




}
