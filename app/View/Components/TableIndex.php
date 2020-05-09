<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableIndex extends Component
{
    public $title;
    public $routeNew;
    public $source;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title,$routeNew,$source)
    {
        $this->title = $title;
        $this->routeNew = $routeNew;
        $this->source = $source;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('cms.layouts.component.table-index');
    }
}
