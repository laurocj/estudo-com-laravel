<div class="col-12 mt-2">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-12 col-md">
                    <h1 class="h2 mb-0">{{ __($title)}}</h1>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group row my-0">
                        <label class="col-sm-auto col-form-label py-1 pr-0">Mostrando</label>
                        <form class="col-sm-auto pl-1">

                            @if (Request::has('q') && !empty(Request::get('q')))
                                <input type="hidden" name="q" value="{{Request::get('q')}}">
                            @endif

                            <select name="itensPerPages" class="form-control form-control-sm" onchange="this.parentElement.submit()">
                                <option @if (Request::get('itensPerPages') == 10) selected @endif value="10">10</option>
                                <option @if (Request::get('itensPerPages') == 25) selected @endif value="25">25</option>
                                <option @if (Request::get('itensPerPages') == 50) selected @endif value="50">50</option>
                                <option @if (Request::get('itensPerPages') == 100) selected @endif value="100">100</option>
                            </select>
                        </form>
                        <div class="col-sm py-1 pl-0">registros</div>
                    </div>
                </div>
                <div class="col-sm-12 col-md">
                    <form class="navbar-search">
                        @if (Request::has('itensPerPages'))
                            <input type="hidden" name="itensPerPages" value="{{Request::get('itensPerPages')}}">
                        @endif
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm small" name="q" value="{{Request::get('q')}}" placeholder="Buscar...">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm" type="submit">
                                    <span class="material-icons">search</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-sm-12 col-md-auto">
                    @can('category-create')
                        <a href="{{ $routeNew }}" class="btn btn-primary">{{__('New')}}</a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped">
                    <thead>
                       {{ $thead }}
                    </thead>
                    <tbody>
                        {{ $tbody }}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-12 col-md-5">

                </div>
                <div class="col-sm-12 col-md-7 d-flex justify-content-center">
                    {!! $source->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
