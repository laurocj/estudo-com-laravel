<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Cms\CmsController;
use App\Http\Requests\ProductsFormRequest;
use Illuminate\Http\Request;
use App\Model\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Services\ProductService;

class ProductsController extends CmsController
{

    /**
     * Path to views
     */
    protected $_path = 'cms.products.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = 'Cms\ProductsController@index';

    /**
     * Repository
     *
     * @var \App\Repository\ProductRepository $repository
     */
    private $repository;

    /**
     * Construct
     */
    function __construct(ProductRepository $repository)
    {
        parent::__construct('product');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->repository->paginate($this->_itensPerPages);
        return $this->showView(__FUNCTION__, compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->lists('name');
        return $this->showView(__FUNCTION__, compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ProductsFormRequest  $request
     * @param  App\Services\ProductService
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsFormRequest $request, ProductService $service)
    {
        $product = $service->create(
            $request->name,
            $request->stock,
            $request->price,
            $request->category_id
        );

        return $this->returnIndexStatusOk($product->name . ' created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, CategoryRepository $categoryRepository)
    {
        $product = $this->repository->find($id);

        if (empty($product)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $categories = $categoryRepository->lists('name');

        return $this->showView(__FUNCTION__, compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ProductsFormRequest  $request
     * @param  App\Services\ProductService $service
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsFormRequest $request, ProductService $service, $id)
    {
        $product = $this->repository->find($id);

        if (empty($product)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $service->update(
            $product,
            $request->only(['name', 'stock', 'price', 'category_id'])
        );

        return $this->returnIndexStatusOk('Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->repository->find($id);

        if (empty($product)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $this->repository->delete($product);

        return $this->returnIndexStatusOk('Deleted');
    }
}