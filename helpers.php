<?php

use App\Core\Layout;
use App\Core\Slots;
use Kirby\Toolkit\A;

function env(string $key)
{
    $data = parse_ini_file('.env', true);
    return A::get($data, $key);
}

function layout($name = null, ?array $data = null)
{
    if (is_array($name) === true) {
        $data = $name;
        $name = null;
    }

    Layout::start($name, $data);
}

function slot(?string $name = null)
{
    Slots::start($name);
}

function endslot()
{
    echo Slots::end();
}


