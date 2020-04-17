<?php


namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\CmsController;
use App\Http\Requests\UsersFormRequest;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Services\UserService;
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
     * Repository
     *
     * @var \App\Repository\UserRepository $repository
     */
    private $repository;



    /**
     * Construct
     */
    function __construct(UserRepository $repository)
    {
        parent::__construct('user');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->repository->paginate($this->_itensPerPages);
        return $this->showView(__FUNCTION__, compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RoleRepository $roleRepository)
    {
        $roles = $roleRepository->lists('name');
        return $this->showView(__FUNCTION__, compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\UsersFormRequest  $request
     * @param  App\Services\UserService $service
     * @return \Illuminate\Http\Response
     */
    public function store(UsersFormRequest $request, UserService $service)
    {
        $user = $service->create(
            $request->name,
            $request->email,
            $request->password,
            $request->roles
        );

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
        $user = $this->repository->find($id);
        return $this->showView(__FUNCTION__, compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, RoleRepository $roleRepository)
    {
        $user = $this->repository->find($id);

        if (empty($user)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $roles = $roleRepository->lists('name', 'name');

        $userRole = $user->roles->pluck('name', 'name')->all();

        return $this->showView(__FUNCTION__, compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UsersFormRequest  $request
     * @param  App\Services\UserService $service
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersFormRequest $request, UserService $service, $id)
    {
        $user = $this->repository->find($id);

        if (empty($user)) {
            return $this->returnIndexStatusNotOk(__('Not found!!'));
        }

        $service->update(
            $user,
            $request->only(['name', 'email', 'password']),
            $request->input('roles')
        );

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
        $user = $this->repository->find($id);

        if (empty($user)) {
            return $this->returnIndexStatusNotOk(__('Not found!'));
        }

        $this->repository->delete($id);

        return $this->returnIndexStatusOk('User deleted successfully');
    }
}
