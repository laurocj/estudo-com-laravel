<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-12 col-sm">
                <h1 class="h2 mb-0">{{ __($title)}}</h1>
            </div>

            <div class="col-12 col-sm-auto">
                @isset($routeNew)
                    <a href="{{ $routeNew }}" class="btn btn-primary">{{__('New')}}</a>
                @endisset
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-5 col-xl-3">
                <div class="form-group row my-0">
                    <label class="col-auto col-form-label py-1 pr-0">Mostrando</label>
                    <form class="col-auto pl-1">

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
                    <div class="col py-1 pl-0">registros</div>
                </div>
            </div>
            <div class="col-12 col-sm">
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
        </div>
        <div class="table-responsive mt-3 border-top">
            <table class="table table-bordere table-striped">
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
