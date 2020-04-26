<?php

namespace App\Services;

use App\Model\Product;
use App\Repository\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * Product Repository
     *
     * @var ProductRepository
     */
    private $repository;

    /**
     * Product Repository
     * @param ProductRepository
     *
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Delete a model by its primary key
     * @param int $id
     * @return boolean
     *
     * @throws ModelNotFoundException|QueryException
     */
    public function delete(int $id)
    {
        $product = $this->find($id);

        return $this->repository->delete($product);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return Product
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $product = $this->repository->find($id);

        if(empty($product)) {
            throw (new ModelNotFoundException())->setModel(
                get_class(Product::class), $id
            );
        }

        return $product;
    }

    /**
     * @param int $itensPerPages
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $itensPerPages)
    {
        return $this->repository->paginate($itensPerPages);
    }

    /**
     * @param int $itensPerPages
     * @param array $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(int $itensPerPages, array $search)
    {
        return $this->repository->search($itensPerPages,$search);
    }

    /**
     * Create Product
     *
     * @param string $name
     * @param int $stock
     * @param string $price
     * @param int $categoryId
     *
     * @return Product|null
     */
    public function create(string $name, int $stock, string $price, int $categoryId)
    {
        $product = new Product();

        $product->name           = $name;
        $product->stock          = $stock;
        $product->price          = $price;
        $product->category_id    = $categoryId;

        DB::beginTransaction();

        if ($this->repository->save($product)) {
            DB::commit();
            return $product;
        }

        DB::rollBack();
        return null;
    }

    /**
     * Update Product
     * @param int $id
     * @param string $name
     * @param int $stock
     * @param string $price
     * @param int $categoryId
     *
     * @return boolean
     */
    public function update(int $id, string $name, int $stock, string $price, int $categoryId)
    {
        $product = $this->find($id);

        $product->name           = $name;
        $product->stock          = $stock;
        $product->price          = $price;
        $product->category_id    = $categoryId;

        DB::beginTransaction();

        $isOk = $this->repository->save($product);

        if ($isOk) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }
}
