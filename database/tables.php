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
    }
];