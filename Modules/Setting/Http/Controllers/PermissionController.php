<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Cms\CmsController;

use Modules\Setting\Entities\Permission;
use Modules\Setting\Services\PermissionService;
use Modules\Setting\Http\Requests\Permission\PermissionStoreRequest;
use Modules\Setting\Http\Requests\Permission\PermissionUpdateRequest;

/**
 * Class PermissionController
 * @package Modules\Setting\Http\Controllers
 */
class PermissionController extends CmsController
{
    /**
     * Path to views
     */
    protected $_path = 'setting::permission.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = '\Modules\Setting\Http\Controllers\PermissionController@index';

    /**
     * Modules\Setting\Services\PermissionService
     *
     * @var Modules\Setting\Services\PermissionService
     */
    private $service;

    function __construct(PermissionService $service)
    {
        parent::__construct('permission');
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
            $permissions = $this->service
                                ->paginate($this->_itensPerPages)
                                ->appends(['itensPerPages' => $this->_itensPerPages]);
        } else {
            $permissions = $this->search($request);
        }

        return $this->showView(__FUNCTION__, compact('permissions'));
    }

    /**
     * Para pesquisa
     * @param Request $request
     */
    public function search(Request $request)
    {
        if ($request->has('q')) {
            $search = [];
            $search['name'] = $request->q;
            $appends['q'] = $request->q;
            $appends['itensPerPages'] = $this->_itensPerPages;

            return $this->service
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
        return $this->showView('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionStoreRequest $request)
    {
        $permission = $this->service->create(
				$request->name,
				$request->guard_name
                    );

        if (empty($permission)) {
            return $this->returnIndexStatusNotOk(__('Was not created!'));
        }

        return $this->returnIndexStatusOk($permission->name . ' created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $permission = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Not found !'));

        }

        return $this->showView(__FUNCTION__, compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        try {

            if ($this->service->update(
                    $id,
				$request->name,
				$request->guard_name
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
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
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
