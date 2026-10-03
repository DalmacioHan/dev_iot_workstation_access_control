<?php

test('the login page loads', function () {
    $this->withoutVite();

    $response = $this->get('/login');

    $response->assertOk();
});