<?php

namespace App\Services;

use App\Repository\PermissionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionService
{

    /**
     * Permission Repository
     *
     * @var PermissionRepository
     */
    private $repository;

    /**
     * Permission Repository
     * @param PermissionRepository
     */
    public function __construct(PermissionRepository $repository)
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
        $permission = $this->find($id);

        return $this->repository->delete($permission);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return Permission
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $permission = $this->repository->find($id);

        if(empty($permission)) {
            throw (new ModelNotFoundException())->setModel(
                get_class(Permission::class), $id
            );
        }

        return $permission;
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
     * Create Permission
     * @param String $name
     *
     * @return Permission|null
     */
    public function create(String $name)
    {
        $permission = new Permission();
        $permission->name         = $name;

        DB::beginTransaction();

        if ($this->repository->save($permission)) {
            DB::commit();
            return $permission;
        }

        DB::rollBack();
        return null;
    }

    /**
     * Update Permission
     * @param int $id
     * @param string $name
     *
     * @return boolean
     */
    public function update(int $id, string $name)
    {
        $permission = $this->find($id);

        $permission->name         = $name;

        DB::beginTransaction();

        $isOk = $this->repository->save($permission);

        if ($isOk) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }
}
