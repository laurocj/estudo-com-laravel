@extends($_keyLayout)

@section($_keyContent)
<div class="col-12">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 border-bottom">
        <h1 class="h2">{{__('Role Management')}}</h1>

        @can('role-create')
            <a href="{{ route('regras.create') }}" class="btn btn-outline-success">{{__('New')}}</a>
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
            @foreach($roles as $role)
                <tr>
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('regras.show',$role->id) }}">Show</a>
                        @can('role-edit')
                            <a href="{{route('regras.edit',$role->id)}}" class='btn btn-primary btn-sm '>Edit</a>
                        @endcan
                        @can('role-delete')
                            {!! Form::open(array('route' => ['regras.destroy',$role->id],'method' => 'delete','class'=>'d-inline')) !!}
                            {!! Form::submit(__('Delete'), array( 'class'=>'btn btn-danger btn-sm' )) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="align-self-end w-100 bg-light pt-2">
    <div class="d-flex justify-content-center">
        {!! $roles->links() !!}
    </div>
</div>
@endsection

