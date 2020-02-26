<?php

namespace App\Repository;

use App\Model\Product;
use App\Repository\GenericRepository;


class ProductRepository extends GenericRepository
{

    public function __construct()
    {
        parent::__construct(Product::class);
    }
}