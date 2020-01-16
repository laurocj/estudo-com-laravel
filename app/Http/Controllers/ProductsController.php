<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Product;
use App\Model\Category;

class ProductsController extends Controller
{

    /**
     * Folder to views
     */
    private $_folder = 'products.';

    /**
     * Action Index in controller
     */
    private $_actionIndex = 'ProductsController@index';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::paginate(5);
        return $this->showView( __FUNCTION__ , compact('products'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
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

        return $this->returnStatusOk('Created');
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
            return $this->returnStatusNotOk(__('Not found!!'));
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
            return $this->returnStatusNotOk(__('Not found!!'));
        }

        $product->update($request->all());

        return $this->returnStatusOk('Updated');
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
            return $this->returnStatusNotOk(__('Not found!!'));
        } else {
            $product->delete();
        }

        return $this->returnStatusOk('Deleted');
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

    /**
     * Return view
     *
     * @param string $name name of view
     * @param array $data array data returned
     *
     * @return \Illuminate\Http\Response
     */
    protected function showView($name,$data = [])
    {
        return view($this->_folder.$name,$data);
    }

    /**
     * Redirect with ok status
     * @param string $status
     *
     * @return \Illuminate\Http\Response
     */
     protected function returnStatusOk($status)
     {
        return redirect()->action($this->_actionIndex)->with('status',$status);
     }

     /**
     * Redirect with status not ok
     * @param string $status
     *
     * @return \Illuminate\Http\Response
     */
     protected function returnStatusNotOk($status)
     {
        return redirect()->action($this->_actionIndex)->with('status_error',$status);
     }
}
