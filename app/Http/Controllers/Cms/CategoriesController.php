<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Cms\CmsController;
use App\Http\Requests\CategoriesFormRequest;

use Illuminate\Http\Request;

use App\Repository\CategoryRepository;
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
     * Repository
     *
     * @var \App\Repository\CategoryRepository $repository
     */
    private $repository;

    /**
     * Construct
     */
    function __construct(CategoryRepository $repository)
    {
        parent::__construct('category');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = $this->repository->paginate($this->_itensPerPages);

        return $this->showView(__FUNCTION__, compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->showView(__FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CategoriesFormRequest  $request
     * @param  App\Services\CategoryService $service
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesFormRequest $request, CategoryService $service)
    {
        $category = $service->create($request->name);

        if (empty($category)) {
            return $this->returnIndexStatusNotOk(__('Error creating'));
        }

        return $this->returnIndexStatusOk($category->name . ' created');
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
        $category = $this->repository->find($id);

        if (empty($category)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        return $this->showView(__FUNCTION__, compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\CategoriesFormRequest  $request
     * @param  App\Services\CategoryService $service
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesFormRequest $request, CategoryService $service, $id)
    {
        $category = $this->repository->find($id);

        if (empty($category)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $service->update(
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
        $category = $this->repository->find($id);

        if (empty($category)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $this->repository->delete($category);

        return $this->returnIndexStatusOk('Deleted');
    }
}
