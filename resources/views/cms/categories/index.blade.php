@extends($layout)

@section('content')
    <x-table-index title="Categories" :routeNew="route('categorias.create')" :source="$categories">
        <x-slot name="thead">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Title</th>
                <th scope="col">Action</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($categories as $category)
            <tr>
                <th scope="row">{{$category->id}}</th>
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
        </x-slot>
    </x-table-index>
@endsection
