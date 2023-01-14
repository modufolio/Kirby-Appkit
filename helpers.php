<?php

use App\Core\Layout;
use App\Core\Slots;
use Kirby\Toolkit\A;

if (! function_exists('env')) {
    function env(string $key){
        $data = parse_ini_file('.env', true);
        return A::get($data, $key);
    }
}

if (! function_exists('layout')) {
    function layout($name = null, ?array $data = null)
    {
        if (is_array($name) === true) {
            $data = $name;
            $name = null;
        }
        Layout::start($name, $data);
    }
}
if (! function_exists('slot')) {
    function slot(?string $name = null){
        Slots::start($name);
    }
}
if (! function_exists('slot')) {
    function endslot(){
        echo Slots::end();
    }
}


