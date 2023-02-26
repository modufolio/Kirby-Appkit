<?php

namespace App\Core;

use Kirby\Cms\Responder;
use Kirby\Database\Db;
use Kirby\Filesystem\F;
use Kirby\Toolkit\A;
use Kirby\Toolkit\Config;
use Kirby\Toolkit\Str;
use Kirby\Toolkit\V;

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
    /**
     * Returns a specific user by id
     * or the current user if no id is given
     *
     * @param string|null $id
     * @param bool $allowImpersonation If set to false, only the actually
     *                                 logged in user will be returned
     *                                 (when `$id` is passed as `null`)
     * @return \Kirby\Cms\User|null
     */
    public function user(?string $id = null, bool $allowImpersonation = true)
    {
        $id = is_string($id) ? Str::ltrim($id, 'user://') : $id;
        $contentTable   = 'content';
        $languageCode   = $this->multilang() === true ? $this->language()->code() : 'en';

        $where = V::email($id) ? ['email' => $id] : ['id' => $id];

        if ($id !== null) {

            $collection = Db::select('users', '*', $where);
            if($collection->isEmpty() === true) {
                return null;
            }
            $list            = $collection->first();
            $data            = $list->toArray();

            $content         = Db::first($contentTable, '*', $where + ['language' => $languageCode]);
            $data['content'] = $content !== false ? $content->toArray() : [];

            // for multi-language sites, add the translations to the translations array
            if ($this->multilang() === true) {
                unset($data['content']);
                $data['translations'] = $this->getDbContentTranslations($contentTable, $id);
            }

            return User::factory($data);
        }

        if ($allowImpersonation === true && is_string($this->user) === true) {
            return $this->auth()->impersonate($this->user);
        } else {
            try {
                return $this->auth()->user(null, $allowImpersonation);
            } catch (Throwable $e) {
                return null;
            }
        }
    }


    public function users()
    {
        return $this->users = $this->getDbUsers();
    }

    public function getDbUsers(int $offset = 0, ?int $limit = null): Users
    {

        // get cached users if available
        if ($this->users !== null && $offset === null && $limit === null) {
            return $this->users;
        }

        $dbUsers        = [];
        $contentTable   = 'content';
        // get users from database table
        $users          = Db::select(table: 'users', offset: $offset, limit: $limit);
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

        return Users::factory($dbUsers);
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
        $where = V::email($id) ? ['email' => $id] : ['id' => $id];

        $translations = [];
        foreach ($this->languages() as $language) {
            $content =  Db::first($table, '*', $where + [ 'language' => $language->code()]);
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
            'hooks' => F::load($root . '/hooks.php', []) ?? [],
            'pages'   => F::load($root . '/pages.php', []) ?? [],
            'pageMethods' => F::load($root . '/methods.php', []) ?? [],
            'areas'   => F::load($root . '/areas.php', []) ?? [],
        ];

        $options = array_replace_recursive($config, $options);

        // merge into one clean options array
        return $this->options = array_replace_recursive(Config::$data, $options);
    }

}
