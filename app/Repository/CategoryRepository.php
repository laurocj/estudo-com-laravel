<?php

namespace App\Repository;

use App\Model\Category;
use App\Repository\GenericRepository;


class CategoryRepository extends GenericRepository
{

    public function __construct()
    {
        parent::__construct(Category::class);
    }
}