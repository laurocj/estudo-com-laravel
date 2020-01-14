<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;


class RoleController extends Controller
{
    /**
     * Path to views
     */
    private $_folder = 'roles.';

    /**
     * Action Index in controller
     */
    private $_actionIndex = 'RoleController@index';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return $this->showView(__FUNCTION__,compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validatinge($request);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));


        return $this->returnStatusOk('Role created successfully');
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


        return $this->showView(__FUNCTION__,compact('role','rolePermissions'));
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
            return $this->returnStatusNotOk(__('Not found!!'));
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if(empty($role)) {
            return $this->returnStatusNotOk(__('Not found!!'));
        }

        $this->validatinge($request);

        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return $this->returnStatusOk('Role updated successfully');
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
            return $this->returnStatusNotOk(__('Not found!!'));
        } else {
            $role->delete();
        }

        return $this->returnStatusOk('Role deleted successfully');
    }

    /**
     * Regras de validação
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validating(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permission' => 'required',
        ]);
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
        return view($this->_folder.$name,$data);
    }

    /**
     * Redirect with ok status
     * @param string $status
     *
     * @return \Illuminate\Http\Response
     */
     protected function returnStatusOk($status)
     {
        return redirect()->action($this->_actionIndex)->with('status',$status);
     }

     /**
     * Redirect with status not ok
     * @param string $status
     *
     * @return \Illuminate\Http\Response
     */
     protected function returnStatusNotOk($status)
     {
        return redirect()->action($this->_actionIndex)->with('status_error',$status);
     }
}