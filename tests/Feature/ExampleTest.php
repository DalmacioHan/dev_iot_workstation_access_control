<?php

test('the application redirects to login', function () {
    $response = $this->get('/login');

    $response->assertRedirect('/login'); // or ->assertStatus(302)
});
