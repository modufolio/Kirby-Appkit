<?php

namespace App\Core;

use Kirby\Cms\Users as BaseUsers;
use Kirby\Database\Db;

class Users extends BaseUsers
{
    public function create($data): User
    {
        return User::create($data);
    }

    public static function factory(array $users, array $inject = []): static
    {
        $collection = new static();

        // read all user blueprints
        foreach ($users as $props) {
            $user = User::factory($props + $inject);
            $collection->set($user->id(), $user);
        }

        return $collection;
    }
}
