<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginLogoutTest extends TestCase
{
    /**
     * A test url login
     */
    public function testUrlLogin()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * A test url logout.
     */
    public function testUrlLogout()
    {
        $response = $this->post('/logout');

        $response->assertStatus(302);
    }

    /**
     * A test login error
     */
    public function testLoginFalse()
    {
        $credential = [
            'email' => 'admin@gmail.com',
            'password' => '123456$$'
        ];

        $response = $this->post('login',$credential);

        $response->assertSessionHasErrors();
    }

    /**
     * A test login not error
     */
    public function testLoginTrue()
    {
        $credential = [
            'email' => 'admin@gmail.com',
            'password' => '123456'
        ];

        $response = $this->post('login',$credential);

        $response->assertSessionMissing('errors');
    }

    /**
     * A test url Forbidden.
     */
    public function testUrlForbidden()
    {
        $credential = [
            'email' => 'teste@teste.com',
            'password' => '123456'
        ];

        $this->post('login',$credential);

        $response = $this->get('/cms/users/1/editar');

        $response->assertForbidden();
    }

}
