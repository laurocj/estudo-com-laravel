@extends($layout)

@section('content')
<div class="container">
    <div class="col-12">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if (session('status_error'))
            <div class="alert alert-danger">
                {{ session('status_error') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h5 class='card-title'>{{__('Categories')}}</h5>
                    </div>
                    <div class="col-12 col-md-6 text-right">
                        <a href="{{ route('categorias.create') }}"
                            class="btn btn-outline-success"
                        >{{__('New')}}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-ordered">
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
                                {{ Form::open(array('route' => ['categorias.destroy',$category->id],'method' => 'delete','class'=>'d-inline')) }}
                                {{ Form::submit(__('Delete'), array( 'class'=>'btn btn-danger btn-sm' )) }}
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $categories->links() }}

        </div>
    </div>
</div>
@endsection