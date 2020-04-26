<?php

namespace App\Services;

use App\Repository\UserRepository;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{

    /**
     * User Repository
     *
     * @var UserRepository
     */
    private $repository;

    /**
     * User Repository
     * @param UserRepository
     *
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Delete a model by its primary key
     * @param int $id
     * @return boolean
     *
     * @throws ModelNotFoundException|QueryException
     */
    public function delete(int $id)
    {
        $user = $this->find($id);

        return $this->repository->delete($user);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return User
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $user = $this->repository->find($id);

        if(empty($user)) {
            throw (new ModelNotFoundException())->setModel(
                get_class(User::class), $id
            );
        }

        return $user;
    }

    /**
     * @param int $itensPerPages
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $itensPerPages)
    {
        return $this->repository->paginate($itensPerPages);
    }

    /**
     * @param int $itensPerPages
     * @param array $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(int $itensPerPages, array $search)
    {
        return $this->repository->search($itensPerPages,$search);
    }

    /**
     * Create User
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param array $roles
     *
     * @return User|null
     */
    public function create(string $name, string $email, string $password, array $roles = [])
    {
        $user = new User();
        $user->name         = $name;
        $user->email        = $email;
        $user->password     = $this->encrypt($password);

        DB::beginTransaction();

        if ($this->repository->save($user)) {
            if (!empty($roles)) {
                $user->assignRole($roles);
            }
            DB::commit();
            return $user;
        }
        DB::rollBack();
        return null;

    }

    /**
     * Update User
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $password
     * @param array $roles
     *
     * @return boolean
     *
     * @throws ModelNotFoundException
     */
    public function update(int $id, string $name, string $email, string $password, array $roles = [])
    {
        $user = $this->find($id);

        $user->name         = $name;
        $user->email        = $email;
        $user->password     = $this->encrypt($password);

        DB::beginTransaction();

        $isOk = $this->repository->save($user);

        if ($isOk) {
            if (!empty($roles)) {
                $user->assignRole($roles);
            }
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }

    /**
     * @param string $user
     *
     * @return string
     */
    private function encrypt(string $password)
    {
        return Hash::make($password);
    }
}
