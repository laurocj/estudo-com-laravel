<?php

namespace App\Services;

use App\Model\Category;
use App\Services\PaginatedAbstract;

class CategoryService extends PaginatedAbstract {

    /**
     *  Get paged items
     *
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPagedItems(int $perPage)
    {
        return $this->paginate(new Category, $perPage);
    }

    /**
     *  Get item by id
     *
     * @param int $id
     *
     * @return Category
     */
    public function find($id) {
        return Category::find($id);
    }

    /**
     * Create Category
     *
     * @param String $name
     *
     * @return Category
     */
    public function create(String $name)
    {
        return Category::create([
            'name' => $name
        ]);
    }

    /**
     * Update Category
     *
     * @param Category $category
     * @param Array $newValue
     *
     * @return boolean
     */
    public function update(Category $category, Array $newValue)
    {
        foreach($newValue as $column => $value){
            $category->$column = $value;
        }

        return $category->update();
    }

    /**
     * Delete the Category from the database.
     *
     * @param Category $category
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete(Category $category)
    {
        return $category->delete();
    }
}
