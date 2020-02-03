<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Cms\CmsController;
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
     * Constructor
     */
    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::paginate($this->_itensPerPages);
        return $this->showViewPaginate($request, __FUNCTION__ , compact('products'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validating($request);

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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validating($request);

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

    /**
     * Regras de validação
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validating(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products|max:255',
            'stock' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0.01',
            'category_id' => 'required',
        ]);
    }
}
