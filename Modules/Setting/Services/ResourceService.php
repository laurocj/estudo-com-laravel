<?php

namespace Modules\Setting\Services;

use Illuminate\Support\Facades\DB;
use Modules\Setting\Entities\Resource;
use Modules\Setting\Repository\ResourceRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResourceService
{

    /**
     * Resource Repository
     *
     * @var ResourceRepository
     */
    private $repository;

    /**
     * Resource Repository
     * @param ResourceRepository
     *
     * @return this
     */
    public function __construct(ResourceRepository $repository)
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
        $resource = $this->find($id);

        return $this->repository->delete($resource);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return Resource
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $resource = $this->repository->find($id);

        if(empty($resource)) {
            throw (new ModelNotFoundException)->setModel(
                get_class(Resource::class), $id
            );
        }

        return $resource;
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
     * Create Resource
     * @param string $name
     *
     * @return Boolean|Resource
     */
    public function create(
		string $name
    ) {

        $resource = new Resource();
        
		$resource->name = $name;

        DB::beginTransaction();

        $isOk = $this->repository->save($resource);

        if ($isOk) {
            DB::commit();
            return $resource;
        } else {
            DB::rollBack();
            return $isOk;
        }
    }

    /**
     * Update Resource
     *
     * @param int $id
     * @param string $name
     *
     * @return boolean
     */
    public function update(
        int $id,
		string $name
    ) {

        $resource = $this->repository->find($id);
        $resource->id = $id;
		$resource->name = $name;

        DB::beginTransaction();

        $isOk = $this->repository->save($resource);

        if ($isOk) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }
}
