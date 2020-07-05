<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Cms\CmsController;

use Modules\Setting\Entities\Acl;
use Modules\Setting\Entities\Resource;
use Modules\Setting\Entities\Role;
use Modules\Setting\Services\AclService;
use Modules\Setting\Http\Requests\Acl\AclStoreRequest;
use Modules\Setting\Http\Requests\Acl\AclUpdateRequest;

/**
 * Class AclController
 * @package App\Http\Controllers
 */
class AclController extends CmsController
{
    /**
     * Path to views
     */
    protected $_path = 'setting::acl.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = '\Modules\Setting\Http\Controllers\AclController@index';

    /**
     * Modules\Setting\Services\AclService
     *
     * @var Modules\Setting\Services\AclService
     */
    private $service;

    function __construct(AclService $service)
    {
        parent::__construct('acl');
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
            $acls = $this->service
                                ->paginate($this->_itensPerPages)
                                ->appends(['itensPerPages' => $this->_itensPerPages]);
        } else {
            $acls = $this->search($request);
        }

        return $this->showView(__FUNCTION__, compact('acls'));
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

    public function sync()
    {
        $this->service->controllerToResource();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $resources = Resource::all();
        return $this->showView('create',compact('roles','resources'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AclStoreRequest $request)
    {
        //dd($request->all());
        $acl = $request->acl;

        foreach ($acl['resource'] as $resourceId => $actions) {
            //delete all pre-existing access control settings for this resource;
            Acl::where(['resource_id' => $resourceId])->delete();
            foreach ($actions['action'] as $actionId => $role ) {
                foreach ($role['role'] as $roleId => $y){
                    $acl = new Acl();
                    $acl->action_id = $actionId;
                    $acl->resource_id = $resourceId;
                    $acl->role_id = $roleId;
                    $acl->save();
                }
            }
        }
        // $acl = $this->service->create(
		// 		$request->role_id,
		// 		$request->action_id,
		// 		$request->resource_id
        //             );

        if (empty($acl)) {
            return $this->returnIndexStatusNotOk(__('Was not created!'));
        }

        return $this->returnIndexStatusOk($acl->name . ' created');
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

            $acl = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Not found !'));

        }

        return $this->showView(__FUNCTION__, compact('acl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AclUpdateRequest $request, $id)
    {
        try {

            if ($this->service->update(
                    $id,
				$request->role_id,
				$request->action_id,
				$request->resource_id
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
