<?php

namespace App\Services;

use App\Model\Category;
use App\Repository\CategoryRepository;

class CategoryService
{

    /**
     * Category Repository
     *
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * Category Repository
     * @param CategoryRepository
     *
     * @return this
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
        return $this->categoryRepository->create([
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
    public function update(Category $category, array $newValue)
    {
        $attribules = [];
        foreach ($newValue as $column => $value) {
            $attribules[$column] = $value;
        }

        return $this->categoryRepository->update($category, $attribules);
    }
}