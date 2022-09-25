<?php

namespace App\Core;

use Kirby\Cms\Responder;
use Kirby\Database\Db;
use Kirby\Filesystem\F;
use Kirby\Toolkit\Config;

final class App extends \Kirby\Cms\App
{

    /**
     * Response configuration
     *
     * @return Responder
     */
    public function response(): Responder
    {
        return $this->response = $this->response ?? (new Responder())->headers(Config::get('headers'));
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

    public function users()
    {
        // get cached users if available
        if ($this->users !== null) {
            return $this->users;
        }

        $dbUsers        = [];
        $contentTable   = 'content';
        // get users from database table
        $users          = Db::select('users');
        $languageCode   = $this->multilang() === true ? $this->language()->code() : 'en';

        // loop through the users collection
        foreach ($users as $user) {
            $data            = $user->toArray();
            $content         = Db::first($contentTable, '*', ['id' => $user->id(), 'language' => $languageCode]);
            $data['content'] = $content !== false ? $content->toArray() : [];

            // for multi-language sites, add the translations to the translations array
            if ($this->multilang() === true) {
                unset($data['content']);
                $data['translations'] = $this->getDbContentTranslations($contentTable, $user->id());
            }
            // append data to the `$dbUsers` array
            $dbUsers[] = $data;
        }

        return $this->users = Users::factory($dbUsers);
    }

    /**
     * Build content translations array
     *
     * @param string $table
     * @param string $id
     * @return array
     */
    protected function getDbContentTranslations(string $table, string $id): array
    {
        $translations = [];
        foreach ($this->languages() as $language) {
            $content =  Db::first($table, '*', ['id' => $id, 'language' => $language->code()]);
            if ($language === $this->defaultLanguage()) {
                $translations[] = [
                    'code'    => $language->code(),
                    'content' => $content !== false ? $content->toArray() : [],
                ];
            } else {
                $translations[] =  [
                    'code'    => $language->code(),
                    'content' => $content !== false ? $content->toArray() : [],
                ];
            }
        }

        return $translations;
    }


    /**
     * Create your own set of app users
     *
     * @param array|null $users
     */
    public function setUsers(array $users = null)
    {
        if ($users !== null) {
            $this->users = Users::factory($users, [
                'kirby' => $this
            ]);
        }

        return $this;
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
            'routes'  => F::load(Roots::ROUTES . '/web.php', []) ?? [],
            'api'     => [
                'routes' => F::load(Roots::ROUTES . '/api.php', []) ?? [],
            ],
            'pages'   => F::load($root . '/pages.php', []) ?? [],
            'pageMethods' => F::load($root . '/methods.php', []) ?? []
        ];

        $options = array_replace_recursive($config, $options);

        // merge into one clean options array
        return $this->options = array_replace_recursive(Config::$data, $options);
    }

}