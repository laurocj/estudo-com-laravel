<?php

namespace Modules\Setting\Services;

use Illuminate\Support\Facades\DB;
use Modules\Setting\Entities\Menu;
use Modules\Setting\Repository\MenuRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MenuService
{

    /**
     * Menu Repository
     *
     * @var MenuRepository
     */
    private $repository;

    /**
     * Menu Repository
     * @param MenuRepository
     *
     * @return this
     */
    public function __construct(MenuRepository $repository)
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
        $menu = $this->find($id);

        return $this->repository->delete($menu);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return Menu
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $menu = $this->repository->find($id);

        if(empty($menu)) {
            throw (new ModelNotFoundException)->setModel(
                get_class(Menu::class), $id
            );
        }

        return $menu;
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
     * Create Menu
     * @param string $name
     *
     * @return Boolean|Menu
     */
    public function create(
		string $name,
		string $route
    ) {

        $menu = new Menu();
        
		$menu->name = $name;
		$menu->route = $route;

        DB::beginTransaction();

        $isOk = $this->repository->save($menu);

        if ($isOk) {
            DB::commit();
            return $menu;
        } else {
            DB::rollBack();
            return $isOk;
        }
    }

    /**
     * Update Menu
     *
     * @param int $id
     * @param string $name
     *
     * @return boolean
     */
    public function update(
        int $id,
		string $name,
		string $route
    ) {

        $menu = $this->repository->find($id);
        $menu->id = $id;
		$menu->name = $name;
		$menu->route = $route;

        DB::beginTransaction();

        $isOk = $this->repository->save($menu);

        if ($isOk) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }
}
