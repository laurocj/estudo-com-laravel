<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Cms\CmsController;
use App\Http\Requests\ProductsFormRequest;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Category;

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
     * Construct
     */
    function __construct()
    {
        parent::__construct('product');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::paginate($this->_itensPerPages);
        return $this->showView( __FUNCTION__ , compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->pluck('name','id');
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
        Product::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        return $this->returnIndexStatusOk('Created');
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
    public function edit($id)
    {
        $product = Product::find($id);

        if(empty($product)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $categories = Category::all()->pluck('name','id');

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
        $product = Product::find($id);

        if(empty($product)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $product->update($request->all());

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
        $product = Product::find($id);

        if(empty($product)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        } else {
            $product->delete();
        }

        return $this->returnIndexStatusOk('Deleted');
    }
}
