<?php

namespace Modules\Setting\Services;

use Illuminate\Support\Facades\DB;
use Modules\Setting\Entities\Action;
use Modules\Setting\Repository\ActionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActionService
{

    /**
     * Action Repository
     *
     * @var ActionRepository
     */
    private $repository;

    /**
     * Action Repository
     * @param ActionRepository
     *
     * @return this
     */
    public function __construct(ActionRepository $repository)
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
        $action = $this->find($id);

        return $this->repository->delete($action);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return Action
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $action = $this->repository->find($id);

        if(empty($action)) {
            throw (new ModelNotFoundException)->setModel(
                get_class(Action::class), $id
            );
        }

        return $action;
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
     * Create Action
     * @param string $name
     *
     * @return Boolean|Action
     */
    public function create(
		string $name,
		int $resource_id
    ) {

        $action = new Action();
        
		$action->name = $name;
		$action->resource_id = $resource_id;

        DB::beginTransaction();

        $isOk = $this->repository->save($action);

        if ($isOk) {
            DB::commit();
            return $action;
        } else {
            DB::rollBack();
            return $isOk;
        }
    }

    /**
     * Update Action
     *
     * @param int $id
     * @param string $name
     *
     * @return boolean
     */
    public function update(
        int $id,
		string $name,
		int $resource_id
    ) {

        $action = $this->repository->find($id);
        $action->id = $id;
		$action->name = $name;
		$action->resource_id = $resource_id;

        DB::beginTransaction();

        $isOk = $this->repository->save($action);

        if ($isOk) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }
}
