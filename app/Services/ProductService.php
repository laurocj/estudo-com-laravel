<?php

namespace App\Services;

use App\Model\Product;
use App\Services\GenericDAO;

class ProductService extends GenericDAO {

    public function __construct() {
        parent::__construct(Product::class);
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
    public function create(String $name,String $stock,String $price,String $categoryId)
    {
        return parent::createWith([
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
    public function update(Product $product ,Array $newValue)
    {
        $attributes  = [];
        foreach($newValue as $column => $value){
            $attributes[$column] = $value;
        }

        return parent::updateIn($product, $attributes);
    }

}
