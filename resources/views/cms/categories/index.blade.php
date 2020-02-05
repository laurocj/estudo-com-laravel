@extends($layout)

@section('content')
<div class="row h-100">
    <div class="col-12">

        @component('cms.layouts.component.alert')
        @endcomponent

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 border-bottom">
            <h1 class="h2">{{__('Categories')}}</h1>

            @can('category-create')
                <a href="{{ route('categorias.create') }}" class="btn btn-outline-success">{{__('New')}}</a>
            @endcan
        </div>

        <table class="table table-ordered ">
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
                            {!! Form::open(array('route' => ['categorias.destroy',$category->id],'method' => 'delete','class'=>'d-inline')) !!}
                            {!! Form::submit(__('Delete'), array( 'class'=>'btn btn-danger btn-sm' )) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="align-self-end w-100 bg-light pt-2">
        <div class="d-flex justify-content-center">
            {!! $categories->links() !!}
        </div>
    </div>
</div>
@endsection
