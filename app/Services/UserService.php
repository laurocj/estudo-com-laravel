<?php

namespace App\Services;

use App\User;
use App\Services\GenericDAO;
use Illuminate\Support\Facades\Hash;

class UserService extends GenericDAO {

    public function __construct() {
        parent::__construct(User::class);
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
    public function create(String $name, String $email, String $password, Array $roles = [])
    {
        $password = $this->encrypt($password);

        $user = parent::createWith([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        if(!empty($roles)) {
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
    public function update(User $user, Array $newValue, Array $roles = [])
    {
        $attributes  = [];
        foreach($newValue as $column => $value) {
            if($column == 'password') {
                $attributes[$column] = $this->encrypt($value);
            } else {
                $attributes[$column] = $value;
            }
        }

        if(!empty($roles)) {
            $user->assignRole($roles);
        }

        return parent::updateIn($user,$attributes);
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
