@extends($layout)

@section('content')
<div class="row h-100">
    <div class="col-12">

        @component('cms.layouts.component.alert')
        @endcomponent

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 border-bottom">
            <h1 class="h2">{{__('Users Management')}}</h1>

            @can('user-create')
                <a href="{{ route('usuarios.create') }}" class="btn btn-outline-success">{{__('New')}}</a>
            @endcan
        </div>

        <table class="table table-ordered">
            <thead>
                <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                        @endforeach
                    @endif
                    </td>
                    <td>
                    <a class="btn btn-sm btn-info" href="{{ route('usuarios.show',$user->id) }}">Show</a>
                    <a class="btn btn-sm btn-primary" href="{{ route('usuarios.edit',$user->id) }}">Edit</a>
                        {!! Form::open(['method' => 'DELETE','route' => ['usuarios.destroy', $user->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="align-self-end w-100 bg-light pt-2">
        <div class="d-flex justify-content-center">
            {!! $users->render() !!}
        </div>
    </div>
</div>
@endsection


