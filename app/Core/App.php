<?php

namespace App\Core;

use App\Http\Router;
use Kirby\Cms\Responder;
use Kirby\Cms\Site;
use Kirby\Filesystem\F;
use Kirby\Toolkit\Config;


final class App extends \Kirby\Cms\App
{

    use DbUsers;

    public function __construct(array $props = [], bool $setInstance = true)
    {
        parent::__construct(array_merge($this->customSetup(), $props), $setInstance);
        $this->extend(
            [
                'areas' => Config::get('areas'),
                'cacheTypes' => [
                    'static' => '\App\Core\StaticCache',
                ]
            ]
        );
    }

    public function customSetup(): array
    {
        return [
            'roots' => [
                'index'    => INDEX_DIR,
                'base'     => $base    = dirname(INDEX_DIR),
                'config'     => $base . '/config',
                'site'     => $base . '/site',
                'storage'  => $storage = $base . '/storage',
                'content'  => $storage . '/content',
                'accounts' => $storage . '/accounts',
                'cache'    => $storage . '/cache',
                'logs'     => $storage . '/logs',
                'sessions' => $storage . '/sessions',
            ]
        ];
    }

    /**
     * Response configuration
     *
     * @return Responder
     */
    public function response(): Responder
    {
        return $this->response = $this->response ?? (new Responder())->headers(Config::get('headers'));
    }

    public function router(): Router
    {
        if ($this->router !== null) {
            return $this->router;
        }

        $routes = $this->routes();

        if ($this->multilang() === true) {
            foreach ($routes as $index => $route) {
                if (empty($route['language']) === false) {
                    unset($routes[$index]);
                }
            }
        }

        $hooks = [
            'beforeEach' => function ($route, $path, $method) {
                $this->trigger('route:before', compact('route', 'path', 'method'));
            },
            'afterEach' => function ($route, $path, $method, $result, $final) {
                return $this->apply('route:after', compact('route', 'path', 'method', 'result', 'final'), 'result');
            }
        ];

        return $this->router = new Router($routes, $hooks);
    }



    /**
     * Sets a custom Site object
     *
     * @param Site|array|null $site
     * @return $this
     */
    protected function setSite($site = null): static
    {
        if (is_array($site) === true) {
            $site = new CustomSite($site + [ // instantiate new custom site model here
                    'kirby' => $this
                ]);
        }

        $this->site = $site;
        return $this;
    }

    /**
     * Initializes and returns the (custom) Site object
     *
     * @return \Kirby\Cms\Site
     */
    public function site(): Site
    {
        return $this->site = $this->site ?? new CustomSite([
            'errorPageId' => $this->options['error'] ?? 'error',
            'homePageId'  => $this->options['home']  ?? 'home',
            'kirby'       => $this,
            'url'         => $this->url('index'),
        ]);
    }

    protected function optionsFromConfig(): array
    {
        // create an empty config container
        Config::$data = [];

        // load the main config options
        $root    = $this->root('config');
        $options = F::load($root . '/config.php', []);

        $config = [
            'headers' => F::load($root . '/headers.php', []) ?? [],
            'api'     => [
                'routes' => F::load(Roots::ROUTES . '/api.php', []) ?? [],
            ],
            'hooks' => F::load($root . '/hooks.php', []) ?? [],
            'pages'   => F::load($root . '/pages.php', []) ?? [],
            'areas'   => F::load($root . '/areas.php', []) ?? [],
        ];
        $config = $config + F::load($root . '/methods.php', []) ?? [];

        $options = array_replace_recursive($config, $options);

        // merge into one clean options array
        return $this->options = array_replace_recursive(Config::$data, $options);
    }

}
