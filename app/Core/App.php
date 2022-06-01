<?php

namespace App\Core;

use Kirby\Cms\Responder;

final class App extends \Kirby\Cms\App
{
    public function sayHello(): string
    {
        return 'Hello world';
    }

    /**
     * Response configuration
     *
     * @return Responder
     */
    public function response(): Responder
    {
        return $this->response = $this->response ?? (new Responder())->header('App', Timer::app() . ' ms');
    }

    /**
     * Sets a custom Site object
     *
     * @param \Kirby\Cms\Site|array|null $site
     * @return $this
     */
    protected function setSite($site = null)
    {
        if (is_array($site) === true) {
            $site = new Site($site + [
                    'kirby' => $this,
                ]);
        }

        $this->site = $site;
        return $this;
    }

    /**
     * Initializes and returns the Site object
     *
     */
    public function site()
    {
        return $this->site = $this->site ?? new Site([
                'errorPageId' => $this->options['error'] ?? 'error',
                'homePageId'  => $this->options['home']  ?? 'home',
                'kirby'       => $this,
                'url'         => $this->url('index'),
            ]);
    }

}