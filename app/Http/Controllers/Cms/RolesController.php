<?php


namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Controllers\Cms\CmsController;
use App\Http\Requests\RolesFormRequest;
use App\Repository\PermissionRepository;
use App\Repository\RoleRepository;
use App\Services\RoleService;

class RolesController extends CmsController
{
    /**
     * Path to views
     */
    protected $_path = 'cms.roles.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = 'Cms\RolesController@index';

    /**
     * Repository
     *
     * @var \App\Repository\RoleRepository $repository
     */
    private $repository;



    /**
     * Construct
     */
    function __construct(RoleRepository $repository)
    {
        parent::__construct('role');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = $this->repository->paginate($this->_itensPerPages);
        return $this->showView(__FUNCTION__, compact('roles'));
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
     * @param  App\Http\Requests\RolesFormRequest  $request
     * @param  App\Services\RoleService $service
     * @return \Illuminate\Http\Response
     */
    public function store(RolesFormRequest $request, RoleService $service)
    {
        $role = $service->create(
            $request->input('name'),
            $request->input('permissions')
        );

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
        $role = $this->repository->find($id);

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
        $role = $this->repository->find($id);

        if (empty($role)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $permissions = $permissionRepository->lists('name');

        $rolePermissions = $role->permissions->pluck('id', 'id')->toArray();

        return $this->showView(__FUNCTION__, compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\RolesFormRequest  $request
     * @param  App\Services\RoleService $service
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolesFormRequest $request, RoleService $service, $id)
    {
        $role = $this->repository->find($id);

        if (empty($role)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $service->update(
            $role,
            ['name' => $request->input('name')],
            $request->input('permissions')
        );

        return $this->returnIndexStatusOk('Role ' . $role->name . ' updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = $this->repository->find($id);

        if (empty($role)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $this->repository->delete($id);

        return $this->returnIndexStatusOk('Role deleted successfully');
    }
}
