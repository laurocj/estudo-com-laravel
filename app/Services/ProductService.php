<?php

namespace App\Services;

use App\Model\Product;
use App\Repository\ProductRepository;

class ProductService
{

    /**
     * Product Repository
     *
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * Product Repository
     * @param ProductRepository
     *
     * @return this
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Create Product
     *
     * @param String $name
     * @param String $stock
     * @param String $price
     * @param String $categoryId
     *
     * @return Product
     */
    public function create(String $name, String $stock, String $price, String $categoryId)
    {
        return $this->productRepository->create([
            'name' => $name,
            'stock' => $stock,
            'price' => $price,
            'category_id' => $categoryId,
        ]);
    }

    /**
     * Update Product
     *
     * @param Product $product
     * @param Array $newValue
     *
     * @return boolean
     */
    public function update(Product $product, array $newValue)
    {
        $attributes  = [];
        foreach ($newValue as $column => $value) {
            $attributes[$column] = $value;
        }

        return $this->productRepository->update($product, $attributes);
    }
}