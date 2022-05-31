<?php

use App\Core\Layout;
use App\Core\Slots;

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


