<?php


namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\CmsController;
use App\Http\Requests\UsersFormRequest;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends CmsController
{

    /**
     * Path to views
     */
    protected $_path = 'cms.users.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = 'Cms\UserController@index';

    /**
     * Construct
     */
    function __construct()
    {
        parent::__construct('user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::paginate($this->_itensPerPages);
        return $this->showViewPaginate($request, __FUNCTION__ ,compact('users'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return $this->showView( __FUNCTION__ ,compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\UsersFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersFormRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return $this->returnIndexStatusOk('User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return $this->showView( __FUNCTION__ ,compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if(empty($user)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();


        return $this->showView( __FUNCTION__ ,compact('user','roles','userRole'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UsersFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersFormRequest $request, $id)
    {
        $user = User::find($id);

        if(empty($user)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,['password']);
        }

        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return $this->returnIndexStatusOk('User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if(empty($user)){
            return $this->returnIndexStatusNotOk(__('Not found!'));
        } else {
            $user->delete();
        }

        return $this->returnIndexStatusOk('User deleted successfully');
    }
}
