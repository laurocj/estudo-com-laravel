<?php

namespace App\Services;

use App\Model\Product;
use App\Services\PaginatedAbstract;

class ProductService extends PaginatedAbstract {

    /**
     *  Get paged items
     *
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPagedItems(int $perPage)
    {
        return $this->paginate(new Product, $perPage);
    }

    /**
     *  Get item by id
     *
     * @param int $id
     *
     * @return Product
     */
    public function find($id) {
        return Product::find($id);
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
        return Product::create([
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
        foreach($newValue as $column => $value){
            $product->$column = $value;
        }

        return $product->update();
    }

    /**
     * Delete the Product from the database.
     *
     * @param Product $product
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete(Product $product)
    {
        return $product->delete();
    }
}
