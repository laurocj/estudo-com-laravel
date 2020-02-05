<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterTest extends TestCase
{

    private $newUser = [];

    protected function setUp() : void
    {
        parent::setUp();

        $this->newUser = [
            'name' => 'Usuario teste',
            'email' => 'teste@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];

        $user = \App\User::where('email',$this->newUser['email']);
        if(!empty($user)) {
            $user->delete();
        }
    }

    /**
     * A test url register
     */
    public function testUrlRegister() : void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * A test name empty
     */
    public function testRegisterNameEmpty() : void
    {
        $this->newUser['name'] = '';

        $response = $this->post('/register',$this->newUser);

        $response->assertSessionHasErrors('name');
    }

    /**
     * A test email empty
     */
    public function testRegisterEmailEmpty() : void
    {
        $this->newUser['email'] = '';

        $response = $this->post('/register',$this->newUser);

        $response->assertSessionHasErrors('email');
    }

    /**
     * A test email not valid
     */
    public function testRegisterEmailNotValid() : void
    {
        $this->newUser['email'] = 'emailnotvalid'; // email@valid is true

        $response = $this->post('/register',$this->newUser);

        $response->assertSessionHasErrors('email');
    }

    /**
     * A test email not unique
     */
    public function testRegisterEmailNotUnique() : void
    {
        $this->newUser['email'] = 'admin@gmail.com';

        $response = $this->post('/register',$this->newUser);

        $response->assertSessionHasErrors('email');
    }

    /**
     * A test password empty
     */
    public function testRegisterPasswordEmpty() : void
    {
        $this->newUser['password'] = '';

        $response = $this->post('/register',$this->newUser);

        $response->assertSessionHasErrors('password');
    }

    /**
     * A test password Min length
     */
    public function testRegisterPasswordMinLength() : void
    {
        $this->newUser['password'] = '123456';

        $this->newUser['password_confirmation'] = $this->newUser['password'];

        $response = $this->post('/register',$this->newUser);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Password does not equal confirmation
     */
    public function testRegisterPasswordDoesNotEqualConfirmation() : void
    {
        $this->newUser['password_confirmation'] = '2222222';

        $response = $this->post('/register',$this->newUser);

        $response->assertSessionHasErrors('password');
    }

    /**
     * A test Ok
     */
    public function testRegisterTrue()
    {
        $response = $this->post('/register',$this->newUser);

        $response->assertSessionMissing('errors');
    }

}
