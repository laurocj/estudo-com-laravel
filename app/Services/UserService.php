<?php

namespace App\Services;

use App\Repository\UserRepository;
use App\User;

use Illuminate\Support\Facades\Hash;

class UserService
{

    /**
     * User Repository
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * User Repository
     * @param UserRepository
     *
     * @return this
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create User
     *
     * @param String $name
     * @param String $email
     * @param String $password
     *
     * @return User
     */
    public function create(String $name, String $email, String $password, array $roles = [])
    {
        $password = $this->encrypt($password);

        $user = $this->userRepository->create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        if (!empty($roles)) {
            $user->assignRole($roles);
        }

        return $user;
    }

    /**
     * Update User
     *
     * @param User $user
     * @param Array $newValue
     *
     * @return boolean
     */
    public function update(User $user, array $newValue, array $roles = [])
    {
        $attributes  = [];
        foreach ($newValue as $column => $value) {
            if ($column == 'password') {
                $attributes[$column] = $this->encrypt($value);
            } else {
                $attributes[$column] = $value;
            }
        }

        if (!empty($roles)) {
            $user->syncRoles($roles);
        }

        return $this->userRepository->update($user, $attributes);
    }

    /**
     * @param String $user
     *
     * @return String
     */
    private function encrypt(String $password)
    {
        return Hash::make($password);
    }
}