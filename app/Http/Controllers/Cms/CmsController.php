<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CmsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Var component alert ok
     */
    protected $_varStatusOk = 'status';

    /**
     * Var component alert not ok
     */
    protected $_varStatusNok = 'status_error';

    /**
     * Number of itens per pages
     */
    protected $_itensPerPages = 5;

    /**
     * Layout default
     */
    protected $_layout = 'cms.layouts.app';

    /**
     * Contruct
     * @param string $modelPermission name of model
     */
    function __construct($modelPermission)
    {
        $this->middleware("permission:$modelPermission-list|$modelPermission-create|$modelPermission-edit|$modelPermission-delet", ['only' => ['index','store']]);
        $this->middleware("permission:$modelPermission-create", ['only' => ['create','store']]);
        $this->middleware("permission:$modelPermission-edit", ['only' => ['edit','update']]);
        $this->middleware("permission:$modelPermission-delete", ['only' => ['destroy']]);
    }

    /**
     * Return view
     *
     * @param string $name name of view
     * @param array $data array data returned
     *
     * @return \Illuminate\Http\Response
     */
    protected function showView($name ,$data = [])
    {
        $this->setLayout($data);

        return view($this->_path.$name,$data);
    }

    /**
     * Redirect with ok status
     * @param string $msg
     *
     * @return \Illuminate\Http\Response
     */
     protected function returnIndexStatusOk($msg)
     {
        return redirect()
            ->action($this->_actionIndex)
            ->with($this->_varStatusOk,$msg);
     }

     /**
     * Redirect with status not ok
     * @param string $msg
     *
     * @return \Illuminate\Http\Response
     */
     protected function returnIndexStatusNotOk($msg)
     {
        return redirect()
            ->action($this->_actionIndex)
            ->with($this->_varStatusNok,$msg);
     }

     /**
     * Set layout
     *
     * @param array $data array data returned
     *
     * @return void
     */
    private function setLayout(&$data = [])
    {
        $data['layout'] = $this->_layout;
    }
}
