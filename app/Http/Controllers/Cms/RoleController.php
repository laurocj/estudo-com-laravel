<?php


namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Controllers\Cms\CmsController;
use App\Http\Requests\RolesFormRequest;
use App\Services\RolesService;

class RoleController extends CmsController
{
    /**
     * Path to views
     */
    protected $_path = 'cms.roles.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = 'Cms\RoleController@index';

    /**
     * Construct
     */
    function __construct()
    {
        parent::__construct('role');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate($this->_itensPerPages);
        return $this->showView( __FUNCTION__,compact('roles'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return $this->showView(__FUNCTION__,compact('permission'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\RolesFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolesFormRequest $request,RolesService $rolesService)
    {
        $role = $rolesService->createRoles(
            $request->input('name'),
            $request->input('permission')
        );

        return $this->returnIndexStatusOk('Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();


        return $this->showView( __FUNCTION__ ,compact('role','rolePermissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);

        if(empty($role)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")
                                ->where("role_has_permissions.role_id",$id)
                                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                                ->all();


        return $this->showView(__FUNCTION__,compact('role','permission','rolePermissions'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\RolesFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolesFormRequest $request, $id)
    {
        $role = Role::find($id);

        if(empty($role)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return $this->returnIndexStatusOk('Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        if(empty($role)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        } else {
            $role->delete();
        }

        return $this->returnIndexStatusOk('Role deleted successfully');
    }

}
