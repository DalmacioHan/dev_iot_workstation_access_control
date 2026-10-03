<?php

test('the login page loads', function () {
    $response = $this->get('/login');

    $response->assertOk();
});