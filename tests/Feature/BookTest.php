<?php

namespace Tests\Unit;

use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * @return void
     */
    public function testAddBookWithoutAuthToken()
    {
        $response = $this->post('/api/books');
        $response->assertStatus(401);
    }

    public function testAddBookWithAuthToken()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->post('/api/auth/login', ['email' => $user->email, 'password' => 'password']);
        $response->assertStatus(200);
        $auth = 'Bearer: ' . $response->headers->get('Authorization');

        $response = $this->post( '/api/books', ['title' => 'test', 'google_id' => 'gNiEADgNuFwC'], ['Authorization' => $auth]);
        $response->assertStatus(201);
    }
}
