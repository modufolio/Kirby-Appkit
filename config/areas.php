<?php

use Kirby\Cms\App;
use Kirby\Database\Db;
use Kirby\Toolkit\Escape;


function pagesPagination(int $total, int $limit): int
{
    if ($total === 0) {
        return 0;
    }

    return (int)ceil($total / $limit);
}

function startPagination(?int $page, int $limit): int
{
    if($page === null) {
        $page = 1;
    }

    $index = $page - 1;

    if ($index < 0) {
        $index = 0;
    }

    return $index * $limit + 1;
}

function endPagination(int $total, int $start, int $limit): int
{
    $value = ($start - 1) + $limit;

    if ($value <= $total) {
        return $value;
    }

    return $total;
}



return [
    'users' => function () {
        return [
            'views' => [
                'users' => [
                    'pattern' => 'users',
                    'action'  => function () {
                        $kirby = App::instance();
                        $role  = $kirby->request()->get('role');
                        $roles = $kirby->roles()->toArray(fn ($role) => [
                            'id'    => $role->id(),
                            'title' => $role->title(),
                        ]);

                        return [
                            'component' => 'k-users-view',
                            'props'     => [
                                'role' => function () use ($kirby, $roles, $role) {
                                    if ($role) {
                                        return $roles[$role] ?? null;
                                    }
                                },
                                'roles' => array_values($roles),
                                'users' => function () use ($kirby, $role) {

                                    $page = $kirby->request()->get('page');
                                    $limit = 20;
                                    $total = Db::count('users');
                                    $pages = pagesPagination($total, $limit);
                                    $firstPage = $total === 0 ? 0 : 1;
                                    $lastPage = $pages;
                                    $start = startPagination($page, $limit);
                                    $end = endPagination($total, $start, $limit);
                                    $offset = $start - 1;

                                    $pagination = compact('page', 'pages', 'firstPage', 'lastPage', 'start', 'end', 'offset', 'limit', 'total');
                                    $users = $kirby->getDbUsers($offset, $limit);

                                    if (empty($role) === false) {
                                        $users = $users->role($role);
                                    }


                                    return [
                                        'data' => $users->values(fn ($user) => [
                                            'id'    => $user->id(),
                                            'image' => $user->panel()->image(),
                                            'info'  => Escape::html($user->role()->title()),
                                            'link'  => $user->panel()->url(true),
                                            'text'  => Escape::html($user->username())

                                        ]),
                                        'pagination' => $pagination
                                    ];
                                },
                            ]
                        ];
                    }

                ]
            ]
        ];
    }
];
