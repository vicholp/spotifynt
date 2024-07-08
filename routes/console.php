<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('db:testing', function () {
    try {
        DB::statement('CREATE DATABASE testing');
    } catch (Exception $e) {
        // phpcs:ignore
        $this->error('Database already exists!'); // @phpstan-ignore-line

        return 0;
    }

    // phpcs:ignore
    $this->info('Database created successfully!'); // @phpstan-ignore-line

    return 0;
})->purpose('Create a new database for testing');
