<?php

use Illuminate\Database\Schema\Blueprint;

return [
    'users' => function (Blueprint $table) {
        $table->text('id');
        $table->string('email');
        $table->string('name')->nullable();
        $table->string('role');
        $table->string('language');
        $table->string('password');
        $table->timestamps();
    },
    'content' => function (Blueprint $table) {
        $table->text('id');
        $table->string('language')->nullable();
        $table->timestamps();
    },
    'albums' => function (Blueprint $table) {
        $table->text('id');
        $table->string('slug');
        $table->string('title');
        $table->string('status')->nullable();
        $table->string('cover')->nullable();
        $table->string('headline')->nullable();
        $table->string('subheadline')->nullable();
        $table->string('text')->nullable();
        $table->string('tags')->nullable();
        $table->timestamps();
    },
    'pages' => function (Blueprint $table) {
        $table->string('id');
        $table->string('lang');
        $table->string('parent')->nullable();
        $table->string('slug');
        $table->boolean('status')->nullable();
        $table->string('template');
        $table->string('title');
        $table->json('content')->nullable();
        $table->timestamps();
        $table->softDeletes();
    },
];

