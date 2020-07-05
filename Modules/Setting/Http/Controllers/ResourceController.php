<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Cms\CmsController;

use Modules\Setting\Entities\Resource;
use Modules\Setting\Services\ResourceService;
use Modules\Setting\Http\Requests\Resource\ResourceStoreRequest;
use Modules\Setting\Http\Requests\Resource\ResourceUpdateRequest;

/**
 * Class ResourceController
 * @package App\Http\Controllers
 */
class ResourceController extends CmsController
{
    /**
     * Path to views
     */
    protected $_path = 'setting::resource.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = '\Modules\Setting\Http\Controllers\ResourceController@index';

    /**
     * Modules\Setting\Services\ResourceService
     *
     * @var Modules\Setting\Services\ResourceService
     */
    private $service;

    function __construct(ResourceService $service)
    {
        parent::__construct('resource');
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
            $resources = $this->service
                                ->paginate($this->_itensPerPages)
                                ->appends(['itensPerPages' => $this->_itensPerPages]);
        } else {
            $resources = $this->search($request);
        }

        return $this->showView(__FUNCTION__, compact('resources'));
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
    public function store(ResourceStoreRequest $request)
    {
        $resource = $this->service->create(
				$request->name
                    );

        if (empty($resource)) {
            return $this->returnIndexStatusNotOk(__('Was not created!'));
        }

        return $this->returnIndexStatusOk($resource->name . ' created');
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

            $resource = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Not found !'));

        }

        return $this->showView(__FUNCTION__, compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResourceUpdateRequest $request, $id)
    {
        try {

            if ($this->service->update(
                    $id,
				$request->name
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
