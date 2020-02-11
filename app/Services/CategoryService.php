<?php

namespace App\Services;

use App\Model\Category;
use App\Services\GenericService;

class CategoryService extends GenericService {

    public function __construct() {
        parent::__construct(Category::class);
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
        return parent::createWith([
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
        $attribules = [];
        foreach($newValue as $column => $value){
            $attribules[$column] = $value;
        }

        return parent::updateIn($category,$attribules);
    }
}
