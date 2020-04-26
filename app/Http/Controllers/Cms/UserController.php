<?php


namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\CmsController;
use App\Http\Requests\UsersFormRequest;
use App\Repository\RoleRepository;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;


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
     * Service
     *
     * @var \App\Service\UserService $service
     */
    private $service;

    /**
     * Construct
     */
    function __construct(UserService $service)
    {
        parent::__construct('user');
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
            $users = $this->service
            ->paginate($this->_itensPerPages)
            ->appends(['itensPerPages' => $this->_itensPerPages]);
        } else {
            $users = $this->search($request);
        }
        return $this->showView(__FUNCTION__, compact('users'));
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
    public function create(RoleRepository $roleRepository)
    {
        $roles = $roleRepository->lists('name');
        return $this->showView(__FUNCTION__, compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\UsersFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersFormRequest $request)
    {
        $user = $this->service->create(
            $request->name,
            $request->email,
            $request->password,
            $request->roles
        );

        if (empty($user)) {
            return $this->returnIndexStatusNotOk(__('Error creating'));
        }

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
        try {

            $user = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Not found !'));

        }
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
        try {

            $user = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Not found !'));

        }

        $roles = $roleRepository->lists('name', 'name');

        $userRole = $user->roles->pluck('name', 'name')->all();

        return $this->showView(__FUNCTION__, compact('user', 'roles', 'userRole'));
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
        try {

            if ($this->service->update(
                    $id,
                    $request->name,
                    $request->email,
                    $request->password,
                    $request->roles
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
