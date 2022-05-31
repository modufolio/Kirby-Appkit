<?php

namespace App\Controllers;

use App\Core\View;

/**
 * Basic controller
 *
 */
class BasicController
{
    public function slotsAction(): string
    {
        return View::render('basic/template', [
            'name'    => 'Kirby',
            'colours' => ['pink', 'yellow', 'blue']
        ]);

    }
}
