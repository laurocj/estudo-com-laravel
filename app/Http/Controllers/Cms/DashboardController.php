<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Cms\CmsController;
use Illuminate\Http\Request;

class DashboardController extends CmsController
{

    /**
     * Path to views
     */
    protected $_path = 'cms.dashboard.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = 'Cms\DashboardController@index';

    /**
     * Construct
     */
    function __construct()
    {
        parent::__construct('dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->showView( __FUNCTION__ );
    }
}
