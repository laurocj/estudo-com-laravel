@extends($layout)

@section('content')
<div class="container">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{ __('Create New User') }}
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                <div class="form-group">
                    {{ Form::label('name', __('Name:')) }}
                    {{ Form::text('name', null, ['class'=> classValidOrInvalidForInput('name',$errors)]) }}
                    <div class="invalid-feedback">
                        @if($errors->has('name'))
                            @foreach($errors->get('name') as $msg)
                            {{$msg}}<br/>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('email', __('E-mail:')) }}
                    {{ Form::text('email', null, ['class'=> classValidOrInvalidForInput('email',$errors)]) }}
                    <div class="invalid-feedback">
                        @if($errors->has('email'))
                            @foreach($errors->get('email') as $msg)
                            {{$msg}}<br/>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('password', __('Password:')) }}
                    {{ Form::text('password', null, ['class'=> classValidOrInvalidForInput('password',$errors)]) }}
                    <div class="invalid-feedback">
                        @if($errors->has('password'))
                            @foreach($errors->get('password') as $msg)
                            {{$msg}}<br/>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('password_confirmation', __('Confirm password:')) }}
                    {{ Form::text('password_confirmation', null, ['class'=> classValidOrInvalidForInput('password_confirmation',$errors)]) }}
                    <div class="invalid-feedback">
                        @if($errors->has('password_confirmation'))
                            @foreach($errors->get('password_confirmation') as $msg)
                            {{$msg}}<br/>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('roles', __('Roles:')) }}
                    {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                    <div class="invalid-feedback">
                        @if($errors->has('roles'))
                            @foreach($errors->get('roles') as $msg)
                            {{$msg}}<br/>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::submit('Save', array( 'class'=>'btn btn-danger' )) }}
                    <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection