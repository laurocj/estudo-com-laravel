<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Cms\CmsController;

use Modules\Setting\Entities\Action;
use Modules\Setting\Services\ActionService;
use Modules\Setting\Http\Requests\Action\ActionStoreRequest;
use Modules\Setting\Http\Requests\Action\ActionUpdateRequest;

/**
 * Class ActionController
 * @package App\Http\Controllers
 */
class ActionController extends CmsController
{
    /**
     * Path to views
     */
    protected $_path = 'setting::action.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = '\Modules\Setting\Http\Controllers\ActionController@index';

    /**
     * Modules\Setting\Services\ActionService
     *
     * @var Modules\Setting\Services\ActionService
     */
    private $service;

    function __construct(ActionService $service)
    {
        parent::__construct('action');
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
            $actions = $this->service
                                ->paginate($this->_itensPerPages)
                                ->appends(['itensPerPages' => $this->_itensPerPages]);
        } else {
            $actions = $this->search($request);
        }

        return $this->showView(__FUNCTION__, compact('actions'));
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
    public function store(ActionStoreRequest $request)
    {
        $action = $this->service->create(
				$request->name,
				$request->resource_id
                    );

        if (empty($action)) {
            return $this->returnIndexStatusNotOk(__('Was not created!'));
        }

        return $this->returnIndexStatusOk($action->name . ' created');
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

            $action = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Not found !'));

        }

        return $this->showView(__FUNCTION__, compact('action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActionUpdateRequest $request, $id)
    {
        try {

            if ($this->service->update(
                    $id,
				$request->name,
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
