<?php

namespace App\Services;

use App\Repository\RoleRepository;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleService
{

    /**
     * Role Repository
     *
     * @var RoleRepository
     */
    private $repository;

    /**
     * Role Repository
     * @param RoleRepository
     */
    public function __construct(RoleRepository $repository)
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
        $role = $this->find($id);

        return $this->repository->delete($role);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return Role
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $role = $this->repository->find($id);

        if(empty($role)) {
            throw (new ModelNotFoundException())->setModel(
                get_class(Role::class), $id
            );
        }

        return $role;
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
     * Create Role
     *
     * @param String $name
     * @param Array $permissions
     *
     * @return Role|null
     */
    public function create(String $name, array $permissions)
    {
        $role = new Role();
        $role->name         = $name;

        DB::beginTransaction();

        if ($this->repository->save($role)) {
            $role->syncPermissions($permissions);
            DB::commit();
            return $role;
        }
        DB::rollBack();
        return null;
    }

    /**
     * Update Role
     * @param int $id
     * @param string $name
     * @param array $permissions
     *
     * @return boolean
     *
     * @throws ModelNotFoundException
     */
    public function update(int $id, string $name, array $permissions)
    {
        $role = $this->find($id);

        $role->name         = $name;

        DB::beginTransaction();

        $isOk = $this->repository->save($role);

        if ($isOk) {
            $role->syncPermissions($permissions);
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }
}
