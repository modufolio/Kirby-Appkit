<?php

require __DIR__ . '/bootstrap.php';

// import classes
use Kirby\Cms\User;
use Kirby\Database\Database;
use Kirby\Toolkit\Str;

$result   = [];
$database = null;
$db       =  BASE_DIR . '/database/data.sqlite';

// only create database file if it doesn't exist yet
if (file_exists($db) === false) {
    echo 'Creating database file…' . PHP_EOL;
    try {
        // create new SQLite database file
        $database = new SQLite3($db);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    if ($database) {
        // create new Database object
        $db = new Database([
            'type'     => 'sqlite',
            'database' => $db,
        ]);
        // only create table if it doesn't exist yet
        if ($db->validateTable('users') === false) {
            echo 'Creating table…' . PHP_EOL;
            // add users table with id, email, name, role, language and password fields
            // all fields use type text
            $db->createTable('users', [
                'id'       => [
                    'type'   => 'text',
                    'unique' => true,
                    'key'    => 'primary'
                ],
                'email'    => [
                    'type' => 'text',
                ],
                'name'     =>  [
                    'type' => 'text',
                ],
                'role'     =>  [
                    'type' => 'text',
                ],
                'language' =>  [
                    'type' => 'text',
                ],
                'password' =>  [
                    'type' => 'text',
                ],
            ]);
            // set the users table as the one we want to query
            $query = $db->table('users');
            // two users show be enough for a start
            $users =  [
                [
                    'id'        => Str::random(8),
                    'email'     => 'admin@getkirby.com',
                    'password'  => User::hashPassword('12345678'),
                    'role'      => 'admin',
                    'language'  => 'en',
                ],
                [
                    'id'        => Str::random(8),
                    'email'     => 'bastian@getkirby.com',
                    'password'  => User::hashPassword('12345678'),
                    'role'      => 'admin',
                    'language'  => 'en',
                ],
            ];
            // loops through users array and insert each data set into users table
            foreach ($users as $user ) {
                $query->values($user);
                $result[] = $query->insert();
            }
        }
    }
    echo 'Users created:' . PHP_EOL;
    dump($result);
} else {
    echo 'Database already exists. Nothing done.';
}