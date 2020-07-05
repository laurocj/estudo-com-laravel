<?php

namespace Modules\Setting\Services;

use Illuminate\Support\Facades\DB;
use Modules\Setting\Entities\Acl;
use Modules\Setting\Repository\AclRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

use Modules\Setting\Entities\Resource;
use Modules\Setting\Entities\Action;

class AclService
{

    /**
     * Acl Repository
     *
     * @var AclRepository
     */
    private $repository;

    /**
     * Acl Repository
     * @param AclRepository
     *
     * @return this
     */
    public function __construct(AclRepository $repository)
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
        $acl = $this->find($id);

        return $this->repository->delete($acl);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return Acl
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $acl = $this->repository->find($id);

        if(empty($acl)) {
            throw (new ModelNotFoundException)->setModel(
                get_class(Acl::class), $id
            );
        }

        return $acl;
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
     * Create Acl
     * @param string $name
     *
     * @return Boolean|Acl
     */
    public function create(
		int $role_id,
		int $action_id,
		int $resource_id
    ) {

        $acl = new Acl();

		$acl->role_id = $role_id;
		$acl->action_id = $action_id;
		$acl->resource_id = $resource_id;

        DB::beginTransaction();

        $isOk = $this->repository->save($acl);

        if ($isOk) {
            DB::commit();
            return $acl;
        } else {
            DB::rollBack();
            return $isOk;
        }
    }

    /**
     * Update Acl
     *
     * @param int $id
     * @param string $name
     *
     * @return boolean
     */
    public function update(
        int $id,
		int $role_id,
		int $action_id,
		int $resource_id
    ) {

        $acl = $this->repository->find($id);
        $acl->id = $id;
		$acl->role_id = $role_id;
		$acl->action_id = $action_id;
		$acl->resource_id = $resource_id;

        DB::beginTransaction();

        $isOk = $this->repository->save($acl);

        if ($isOk) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }

    /**
     *
     * @return bool
     */
    public function controllerToResource()
    {
        $routeCollection = Route::getRoutes();
        foreach (Route::getRoutes() as $route) {
            $controllerAction = $route->getAction("controller");
            $resource = Str::before(Str::afterLast($controllerAction,"\\"),"Controller");
            $action = Str::afterLast($controllerAction,"@");
            dump($resource . " " .$action);
            if(is_null($resource) || is_null($action)){
                continue;
            }

            $this->createActions($resource, $action);
        }
    }

    /**
     * @param string $resource
     * @param array $functions
     * @return bool
     * @throws type
     */
    private function createActions(string $resourceName, string $actionName) : bool
    {
        $resource = $this->getResource($resourceName);
        $action = Action::where(['name' => $actionName, 'resource_id' => $resource->id])->first();
        if(is_null($action)) {
            $action = new Action();
            $action->resource_id = $resource->id;
            $action->name = $actionName;
            if (!$action->save()) {
                throw new \RuntimeException("Action $actionName not save.");
            }
        }
        return true;
    }

    /**
     * @param string $nameResource
     * @return Resource
     */
    private function getResource(String $nameResource) : Resource
    {
        $resource = Resource::where('name', $nameResource)->first();
        if(is_null($resource))
        {
            $resource = new Resource();
            $resource->name = $nameResource;
            if (!$resource->save()) {
                throw new \RuntimeException("Resource $nameResource not save.");
            }
        }

        return $resource;
    }

}
