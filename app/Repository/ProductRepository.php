<?php

namespace App\Repository;

use App\Model\Product;
use App\Repository\GenericRepository;


class ProductRepository
{
    use GenericRepository;

    public function getModel()
    {
        return Product::class;
    }
}