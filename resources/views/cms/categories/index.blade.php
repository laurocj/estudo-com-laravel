@extends($layout)

@section('content')
<div class="row h-100">
    <div class="col-12">

        @component('cms.layouts.component.alert')
        @endcomponent

        <div class="row">
            <div class="col-sm-12 col-md-4">
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
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-auto">
                @can('category-create')
                    <a href="{{ route('categorias.create') }}" class="btn btn-outline-success">{{__('New')}}</a>
                @endcan
            </div>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>
                            <a href="{{route('categorias.edit',$category->id)}}" class='btn btn-primary btn-sm'>Edit</a>

                            <a data-toggle="modal" data-load-url="{{route('categorias.edit',$category->id)}}"
                                data-target="#modalContent" href="#" class='btn btn-dark btn-sm'>Edit - modal</a>


                            {!! Form::open(array('route' => ['categorias.destroy',$category->id],'method' =>
                            'delete','class'=>'d-inline')) !!}
                            {!! Form::submit(__('Delete'), array( 'class'=>'btn btn-danger btn-sm' )) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-5">

            </div>
            <div class="col-sm-12 col-md-7">
                <div class="d-flex justify-content-center">
                    {!! $categories->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
