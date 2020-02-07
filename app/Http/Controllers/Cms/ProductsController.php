<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Cms\CmsController;
use App\Http\Requests\ProductsFormRequest;
use Illuminate\Http\Request;
use App\Model\Category;
use App\Services\CategoryService;
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
     * Service
     *
     * @var \App\Services\ProductService $service
     */
    private $service;

    /**
     * Construct
     */
    function __construct(ProductService $service)
    {
        parent::__construct('product');
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->service->paginate($this->_itensPerPages);
        return $this->showView( __FUNCTION__ , compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryService $categoryService)
    {
        $categories = $categoryService->list('name');
        return $this->showView( __FUNCTION__ , compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ProductsFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsFormRequest $request)
    {
        $product = $this->service->create(
            $request->name,
            $request->stock,
            $request->price,
            $request->category_id
        );

        return $this->returnIndexStatusOk($product->name.' created');
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
    public function edit($id, CategoryService $categoryService)
    {
        $product = $this->service->find($id);

        if(empty($product)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $categories = $categoryService->list('name');

        return $this->showView( __FUNCTION__ , compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ProductsFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsFormRequest $request, $id)
    {
        $product = $this->service->find($id);

        if(empty($product)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $this->service->update(
            $product,
            $request->only(['name','stock','price','category_id'])
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
        $product = $this->service->find($id);

        if(empty($product)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $this->service->delete($product);

        return $this->returnIndexStatusOk('Deleted');
    }
}
