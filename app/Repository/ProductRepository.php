<?php

namespace App\Repository;

use App\Model\Product;
use App\Repository\BaseRepository;

class ProductRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = Product::query();
    }
}
