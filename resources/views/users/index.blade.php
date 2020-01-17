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
                        <h5 class='card-title'>{{__('Users Management')}}</h5>
                    </div>
                    <div class="col-12 col-md-6 text-right">
                        <a href="{{ route('users.create') }}"
                            class="btn btn-outline-success"
                        >{{__('New')}}</a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
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
                            <a class="btn btn-sm btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                            <a class="btn btn-sm btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                              {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                              {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
                              {!! Form::close() !!}
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
              {!! $users->render() !!}
            </div>
        </div>
    </div>
</div>


@endsection