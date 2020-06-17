<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Cms\CmsController;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Modules\Setting\Http\Requests\Role\RolesFormRequest;
use Modules\Setting\Repository\PermissionRepository;
use Modules\Setting\Services\RoleService;

class RolesController extends CmsController
{
    /**
     * Path to views
     */
    protected $_path = 'setting::roles.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = '\Modules\Setting\Http\Controllers\RolesController@index';

    /**
     * Service
     *
     * @var \App\Service\RoleService $service
     */
    private $service;

    /**
     * Construct
     */
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
    public function create(PermissionRepository $permissionRepository)
    {
        $permissions = $permissionRepository->lists('name');
        return $this->showView(__FUNCTION__, compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Setting\Http\Requests\Roles\RolesFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolesFormRequest $request)
    {
        $role = $this->service->create(
            $request->name,
            $request->permissions
        );

        if (empty($role)) {
            return $this->returnIndexStatusNotOk(__('Error creating'));
        }

        return $this->returnIndexStatusOk('Role ' . $role->name . ' created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $role = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Not found !'));

        }

        $rolePermissions = $role->permissions;

        return $this->showView(__FUNCTION__, compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, PermissionRepository $permissionRepository)
    {
        try {

            $role = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Not found !'));

        }

        $permissions = $permissionRepository->lists('name',"","all");

        $rolePermissions = $role->permissions->pluck('id', 'id')->toArray();

        return $this->showView(__FUNCTION__, compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Modules\Setting\Http\Requests\Role\RolesFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolesFormRequest $request, $id)
    {
        try {

            if ($this->service->update(
                    $id,
                    $request->input('name'),
                    $request->input('permissions')
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
