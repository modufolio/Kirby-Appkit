<?php

namespace App\Core;

use Kirby\Cms\Pages;
use Kirby\Filesystem\F;
use Kirby\Toolkit\Config;

final class CustomSite extends \Kirby\Cms\Site
{
    /**
     * Add virtual children to existing children
     */
    public function children(): Pages
    {
        // get existing children
        $children = parent::children();

        $rootConfig    = $this->kirby()->root('config');
        
        if(!is_array($pages = F::load($rootConfig . '/pages.php', []))) {
            return $children;
        }

        // pass virtual children data to the Pages::factory() methods
        $virtualChildren = Pages::factory($pages, $this);
        // return merged collection
        return $children->merge($virtualChildren);
    }

    /**
     * Example custom method
     *
     */
    public function sayHello(): string
    {
        return 'Hello world';
    }
}
