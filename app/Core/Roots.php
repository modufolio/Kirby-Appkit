<?php

namespace App\Core;

class Roots
{
    public const BASE = BASE_DIR . '/';
    public const SITE = self::BASE . 'site';
    public const APP  = self::BASE . 'app';
    public const CORE = self::APP . '/core';
    public const ROUTES = self::BASE . 'routes';
    public const STORAGE  = self::BASE . 'storage';
    public const CONFIG = self::BASE . 'config';
    public const TEMPLATES = self::BASE . 'site/templates';
    public const VIEWS = self::BASE.  'site/views';
    public const SNIPPETS = self::BASE . 'site/snippets';
    public const LAYOUTS = self::BASE . 'site/layouts';
    public const DATABASE = self::BASE . 'database';

}
