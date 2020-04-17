<?php

namespace App\Repository;

use App\Model\Category;
use App\Repository\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = Category::query();
    }
}
