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
     * Service
     *
     * @var \App\Services\CategoryService $service
     */
    private $service;



    /**
     * Construct
     */
    function __construct(CategoryService $service)
    {
        parent::__construct('category');
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = $this->service->paginate($this->_itensPerPages);

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
    public function store(CategoriesFormRequest $request)
    {
        $category = $this->service->create($request->name);

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
    public function edit($id)
    {
        $category = $this->service->find($id);

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
    public function update(CategoriesFormRequest $request, $id)
    {
        $category = $this->service->find($id);

        if(empty($category)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $this->service->update(
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
    public function destroy($id)
    {
        $category = $this->service->find($id);

        if(empty($category)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $this->service->delete($category);

        return $this->returnIndexStatusOk('Deleted');
    }
}
