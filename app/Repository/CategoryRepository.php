<?php

namespace App\Repository;

use App\Model\Category;
use App\Repository\GenericRepository;


class CategoryRepository
{
    use GenericRepository;

    public function getModel()
    {
        return Category::class;
    }
}