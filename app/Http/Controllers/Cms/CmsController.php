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
     * @param string $modalPermission name of model
     */
    function __construct($modalPermission)
    {
        $this->middleware("permission:$modalPermission-list|$modalPermission-create|$modalPermission-edit|$modalPermission-delet", ['only' => ['index','store']]);
        $this->middleware("permission:$modalPermission-create", ['only' => ['create','store']]);
        $this->middleware("permission:$modalPermission-edit", ['only' => ['edit','update']]);
        $this->middleware("permission:$modalPermission-delete", ['only' => ['destroy']]);
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
        $data['layout'] = $this->_layout;

        return view($this->_path.$name,$data);
    }

    /**
     * Return view with paginate
     * 
     * @param string $name name of view
     * @param array $data array data returned
     * 
     * @return \Illuminate\Http\Response
     */
    protected function showViewPaginate(Request $request,$name,$data = [])
    {
        return $this->showView($name,$data)
        ->with('i', ($request->input('page', 1) - 1) * $this->_itensPerPages);
    }

    

    /**
     * Redirect with ok status
     * @param string $status
     * 
     * @return \Illuminate\Http\Response
     */
     protected function returnIndexStatusOk($status)
     {         
        return redirect()
            ->action($this->_actionIndex)
            ->with($this->_varStatusOk,$status);
     }

     /**
     * Redirect with status not ok
     * @param string $status
     * 
     * @return \Illuminate\Http\Response
     */
     protected function returnIndexStatusNotOk($status)
     {         
        return redirect()
            ->action($this->_actionIndex)
            ->with($this->_varStatusNok,$status);
     }
}
