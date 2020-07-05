<?php

namespace Modules\Setting\Services;

use Illuminate\Support\Facades\DB;
use Modules\Setting\Entities\Role;
use Modules\Setting\Repository\RoleRepository;
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
     *
     * @return this
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
            throw (new ModelNotFoundException)->setModel(
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
     * @param string $name
     *
     * @return Boolean|Role
     */
    public function create(
		string $name,
		string $description
    ) {

        $role = new Role();
        
		$role->name = $name;
		$role->description = $description;

        DB::beginTransaction();

        $isOk = $this->repository->save($role);

        if ($isOk) {
            DB::commit();
            return $role;
        } else {
            DB::rollBack();
            return $isOk;
        }
    }

    /**
     * Update Role
     *
     * @param int $id
     * @param string $name
     *
     * @return boolean
     */
    public function update(
        int $id,
		string $name,
		string $description
    ) {

        $role = $this->repository->find($id);
        $role->id = $id;
		$role->name = $name;
		$role->description = $description;

        DB::beginTransaction();

        $isOk = $this->repository->save($role);

        if ($isOk) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }
}
