<?php

namespace Tests\Unit;

use App\Repository\UserRepository;
use App\Services\UserService;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return User
     */
    public function testCreateUser()
    {
        $name = 'Ususario Teste';
        $email = 'email@teste.com';
        $password = 'password';

        $service = new UserService(new UserRepository());

        $user = $service->create(
            $name,
            $email,
            $password
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['name' => $name]);
        $this->assertTrue(Hash::check($password, $user->password));

        return $user;
    }

    /**
     * @depends testCreateUser
     */
    public function testAddRoles(User $user)
    {
        $role = Role::findByName('Admin');

        $user->assignRole([$role->id]);

        $this->assertTrue($user::find($user->id)->hasRole($role->name));
    }

    /**
     * @depends testCreateUser
     */
    public function testUpdateUser(User $user)
    {
        $newName = 'Usuario test';

        $service = new UserService(new UserRepository());

        $updated = $service->update(
            $user,
            ['name' => $newName]
        );

        $this->assertTrue($updated);

        $this->assertEquals(User::find($user->id)->name, $newName);

        $user->delete();
    }
}