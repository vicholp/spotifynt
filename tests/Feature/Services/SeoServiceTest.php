<?php

test('do not index main page', function () {
    $response = $this->get('/');

    $response->assertHeader('x-robots-tag', $value = 'none');
});

test('do not index login page', function () {
    $response = $this->get('/login');

    $response->assertHeader('x-robots-tag', $value = 'none');
});
