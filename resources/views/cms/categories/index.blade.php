@extends($layout)

@section('content')
    @tableIndex([
        'title' => 'Categories',
        'routeNew' => route('categorias.create'),
        'source' => $categories
    ])
        @slot('thead')
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        @endslot
        @slot('tbody')
            @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>
                    <a href="{{route('categorias.edit',$category->id)}}" class='btn btn-primary btn-sm'>Edit</a>

                    {{-- <a data-toggle="modal" data-load-url="{{route('categorias.edit',$category->id)}}"
                        data-target="#modalContent" href="#" class='btn btn-dark btn-sm'>Edit - modal</a> --}}

                    {!! Form::open(array('route' => ['categorias.destroy',$category->id],'method' =>
                    'delete','class'=>'d-inline')) !!}
                    {!! Form::submit(__('Delete'), array( 'class'=>'btn btn-danger btn-sm' )) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        @endslot
    @endtableIndex
@endsection
