<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Cms\CmsController;
use App\Http\Requests\CategoriesFormRequest;

use Illuminate\Http\Request;

use App\Services\CategoryService;

class CategoriesController extends CmsController
{

    /**
     * Path to views
     */
    protected $_path = 'cms.categories.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = 'Cms\CategoriesController@index';

    /**
     * Construct
     */
    function __construct()
    {
        parent::__construct('category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CategoryService $categoryService)
    {
        $categories = $categoryService->getPagedItems($this->_itensPerPages);

        return $this->showView( __FUNCTION__ , compact('categories'));
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
     * @param  App\Http\Requests\CategoriesFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesFormRequest $request, CategoryService $categoryService)
    {
        $category = $categoryService->create($request->name);

        if(empty($category)){
            return $this->returnIndexStatusNotOk(__('Error creating'));
        }

        return $this->returnIndexStatusOk($category->name .' created');
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
        $category = $categoryService->find($id);

        if(empty($category)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        return $this->showView( __FUNCTION__ , compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\CategoriesFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesFormRequest $request, $id, CategoryService $categoryService)
    {
        $category = $categoryService->find($id);

        if(empty($category)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $categoryService->update(
            $category,
            ['name' => $request->input('name')]
        );

        return $this->returnIndexStatusOk('Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, CategoryService $categoryService)
    {
        $category = $categoryService->find($id);

        if(empty($category)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $categoryService->delete($category);

        return $this->returnIndexStatusOk('Deleted');
    }
}
