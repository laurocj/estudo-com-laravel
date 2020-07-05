<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Cms\CmsController;

use Modules\Setting\Entities\Role;
use Modules\Setting\Services\RoleService;
use Modules\Setting\Http\Requests\Role\RoleStoreRequest;
use Modules\Setting\Http\Requests\Role\RoleUpdateRequest;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends CmsController
{
    /**
     * Path to views
     */
    protected $_path = 'setting::role.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = '\Modules\Setting\Http\Controllers\RoleController@index';

    /**
     * Modules\Setting\Services\RoleService
     *
     * @var Modules\Setting\Services\RoleService
     */
    private $service;

    function __construct(RoleService $service)
    {
        parent::__construct('role');
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
            $roles = $this->service
                                ->paginate($this->_itensPerPages)
                                ->appends(['itensPerPages' => $this->_itensPerPages]);
        } else {
            $roles = $this->search($request);
        }

        return $this->showView(__FUNCTION__, compact('roles'));
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
    public function store(RoleStoreRequest $request)
    {
        $role = $this->service->create(
				$request->name,
				$request->description
                    );

        if (empty($role)) {
            return $this->returnIndexStatusNotOk(__('Was not created!'));
        }

        return $this->returnIndexStatusOk($role->name . ' created');
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

            $role = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Not found !'));

        }

        return $this->showView(__FUNCTION__, compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        try {

            if ($this->service->update(
                    $id,
				$request->name,
				$request->description
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
