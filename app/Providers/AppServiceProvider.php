<?php

namespace App\Providers;

use App\View\Components\TableIndex;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadBladeComponet();
    }


    private function loadBladeComponet()
    {
        Blade::include('cms.includes.input', 'input');
        Blade::include('cms.includes.check', 'check');
        Blade::include('cms.includes.destroy', 'destroy');
        Blade::component('table-index', TableIndex::class);
    }
}
