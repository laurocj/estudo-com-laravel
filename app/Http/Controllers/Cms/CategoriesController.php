<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\Category;

class CategoriesController extends Controller
{

    /**
     * Path to views
     */
    private $_path = 'cms.categories.';

    /**
     * Action Index in controller
     */
    private $_actionIndex = 'CategoriesController@index';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::paginate(5);
        return $this->showView( __FUNCTION__ , compact('categories'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->showView( __FUNCTION__ );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Category::create([
            'name' => $request->name
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
        $category = Category::find($id);

        if(empty($category)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        
        return $this->showView( __FUNCTION__ , compact('category'));
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
        $category = Category::find($id);

        if(empty($category)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $category->name = $request->input('name');
        
        $category->save();

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
        $category = Category::find($id);

        if(!empty($category)){
            $category->delete();
        }

        return $this->returnIndexStatusOk('Deleted');
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
        return view($this->_path.$name,$data);
    }

    /**
     * Redirect with ok status
     * @param string $status
     * 
     * @return \Illuminate\Http\Response
     */
     protected function returnIndexStatusOk($status)
     {         
        return redirect()->action($this->_actionIndex)->with('status',$status);
     }

     /**
     * Redirect with status not ok
     * @param string $status
     * 
     * @return \Illuminate\Http\Response
     */
     protected function returnIndexStatusNotOk($status)
     {         
        return redirect()->action($this->_actionIndex)->with('status_error',$status);
     }
     
}
