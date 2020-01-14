@extends('layouts.app')


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
                        <h5 class='card-title'>{{__('Role Management')}}</h5>
                    </div>
                    <div class="col-12 col-md-6 text-right">
                        @can('role-create')
                            <a href="{{ route('roles.create') }}"
                                class="btn btn-outline-success"
                            >{{__('New')}}</a>
                        @endcan
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
                    @foreach($roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ route('roles.show',$role->id) }}">Show</a>
                                @can('role-edit')
                                <a href="{{route('roles.edit',$role->id)}}" class='btn btn-primary btn-sm '>Edit</a>
                                @endcan
                                @can('role-delete')
                                    {{ Form::open(array('route' => ['roles.destroy',$role->id],'method' => 'delete','class'=>'d-inline')) }}
                                    {{ Form::submit(__('Delete'), array( 'class'=>'btn btn-danger btn-sm' )) }}
                                    {{ Form::close() }}
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $roles->links() }}

        </div>
    </div>
</div>

@endsection