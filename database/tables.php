<?php

return [
    'users' => function ($table) {
        $table->text('id');
        $table->string('email');
        $table->string('name')->nullable();
        $table->string('role');
        $table->string('language');
        $table->string('password');
        $table->timestamps();
    },
    'content' => function ($table) {
        $table->text('id');
        $table->string('language')->nullable();
        $table->timestamps();
    },
    'albums' => function ($table) {
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
];

