<?php

namespace App\Services;

use App\Model\Category;
use App\Repository\CategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CategoryService
{

    /**
     * Category Repository
     *
     * @var CategoryRepository
     */
    private $repository;

    /**
     * Category Repository
     * @param App\Repository\CategoryRepository
     *
     */
    public function __construct(CategoryRepository $repository)
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
        $category = $this->find($id);

        return $this->repository->delete($category);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return Category
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $category = $this->repository->find($id);

        if(empty($category)) {
            throw (new ModelNotFoundException)->setModel(
                get_class(Category::class), $id
            );
        }

        return $category;
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
     * Create Category
     * @param String $name
     *
     * @return Category
     */
    public function create(String $name)
    {
        $category = new Category();
        $category->name         = $name;

        DB::beginTransaction();

        $isOk = $this->repository->save($category);

        if ($isOk) {
            DB::commit();
            return $category;
        } else {
            DB::rollBack();
            return $isOk;
        }
    }

    /**
     * Update Category
     * @param int $id
     * @param string $name
     *
     * @return boolean
     *
     * @throws ModelNotFoundException
     */
    public function update(int $id, string $name)
    {
        $category = $this->find($id);

        $category->name         = $name;

        DB::beginTransaction();

        $isOk = $this->repository->save($category);

        if ($isOk) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }
}
