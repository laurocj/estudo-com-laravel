<?php

namespace App\Services;

use App\User;
use App\Services\PaginatedAbstract;
use Illuminate\Support\Facades\Hash;

class UserService extends PaginatedAbstract {

    /**
     *  Get paged items
     *
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPagedItems(int $perPage)
    {
        return $this->paginate(new User, $perPage);
    }

    /**
     *  Get item by id
     *
     * @param int $id
     *
     * @return User
     */
    public function find($id) {
        return User::find($id);
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
        $password = Hash::make($password);

        $user = User::create([
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
        foreach($newValue as $column => $value) {
            if($column == 'password') {
                $user->$column = Hash::make($value);
            } else {
                $user->$column = $value;
            }
        }

        if(!empty($roles)) {
            $user->assignRole($roles);
        }

        return $user->update();
    }

    /**
     * Delete the User from the database.
     *
     * @param User $user
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete(User $user)
    {
        return $user->delete();
    }
}
