<?php

test('create user', function () {
    $this->artisan('make:user')
         ->expectsQuestion('What is your name?', 'Taylor Otwell')
         ->expectsQuestion('What is your email?', 'taylor@laravel.com')
         ->expectsQuestion('What is your password?', 'password')
         ->expectsOutput('User created successfully!')
         ->assertExitCode(0);
});
