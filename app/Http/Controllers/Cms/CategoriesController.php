<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Cms\CmsController;
use App\Http\Requests\CategoriesFormRequest;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

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
     * @var App\Services\CategoryService $service
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
        $this->_itensPerPages = $request->itensPerPages ?? $this->_itensPerPages;
        if (empty($request->q)) {
            $categories = $this->service
            ->paginate($this->_itensPerPages)
            ->appends(['itensPerPages' => $this->_itensPerPages]);
        } else {
            $categories = $this->search($request);
        }

        return $this->showView(__FUNCTION__, compact('categories'));
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
    public function create()
    {
        return $this->showView(__FUNCTION__);
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
        try {

            $category = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Not found !'));

        }

        return $this->showView(__FUNCTION__, compact('category'));
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
        try {

            if ($this->service->update(
                    $id,
                    $request->input('name')
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
