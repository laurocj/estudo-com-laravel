<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Cms\CmsController;
use App\Http\Requests\ProductsFormRequest;
use Illuminate\Http\Request;
use App\Repository\CategoryRepository;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

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
     * @var \App\Service\ProductService $service
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
        $this->_itensPerPages = $request->itensPerPages ?? $this->_itensPerPages;
        if (empty($request->q)) {
            $products = $this->service
            ->paginate($this->_itensPerPages)
            ->appends(['itensPerPages' => $this->_itensPerPages]);
        } else {
            $products = $this->search($request);
        }

        return $this->showView(__FUNCTION__, compact('products'));
    }

    /**
     * For research
     * @param Request $request
     */
    public function search(Request $request)
    {
        if ($request->has('q')) {
            $search = [];
            $search['name'] = $request->q;
            $appends['q'] = $request->q;
            $appends['itensPerPages'] = $this->_itensPerPages;
            return $this
                ->service
                ->search($appends['itensPerPages'], $search)
                ->appends($appends);
        }
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
        $product = $this->service->create(
            $request->name,
            $request->stock,
            $request->price,
            $request->category_id
        );

        if (empty($product)) {
            return $this->returnIndexStatusNotOk(__('Error creating'));
        }

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
        try {

            $product = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Not found !'));

        }

        $categories = $categoryRepository->lists('name');

        return $this->showView(__FUNCTION__, compact('product', 'categories'));
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
        try {

            if ($this->service->update(
                    $id,
                    $request->name,
                    $request->stock,
                    $request->price,
                    $request->category_id
                )
            )
                return $this->returnIndexStatusOk(__('Updated !'));

        } catch (\Throwable $th) {

            if($th instanceof ModelNotFoundException)
                $error = __('Not found !');
        }

        return $this->returnIndexStatusNotOk($error ?? 'Not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            if ($this->service->delete($id)) {
                return $this->returnIndexStatusOk(__('Deleted !'));
            }

        } catch (\Throwable $th) {

            if($th instanceof QueryException && Str::is('*Integrity constraint violation*',$th->getMessage()))
                $error = 'It cannot be deleted, it is in use in another record.';

            if($th instanceof ModelNotFoundException)
                $error = __('Not found !');
        }

        return $this->returnIndexStatusNotOk($error ?? "Not Deleted !");
    }
}
