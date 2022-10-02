<?php

namespace App\Core;

class Roots
{
    CONST BASE = BASE_DIR . DS;
    CONST SITE = self::BASE . 'site';
    CONST APP  = self::BASE . 'app';
    CONST CORE = self::APP . 'core';
    CONST ROUTES = self::BASE . 'routes';
    CONST STORAGE  = self::BASE . 'storage';
    CONST CONFIG = self::BASE . 'site/config';
    CONST TEMPLATES = self::BASE . 'site/templates';
    CONST VIEWS = self::BASE.  'site/views';
    CONST SNIPPETS = self::BASE . 'site/snippets';
    const LAYOUTS = self::BASE . 'site/layouts';
    const DATABASE = self::BASE . 'database';

}