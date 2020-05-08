@extends($layout)

@section('content')
<div class="col-12">
    <div class="pt-4 pb-2 border-bottom">
        <h1 class="h2">{{__('Create New User')}}</h1>
    </div>
</div>

<div class="col-12 col-sm-9 mx-auto mt-4">
    {!! Form::open(array('route' => 'usuarios.store','method'=>'POST')) !!}
    <div class="form-group">
        {!! Form::label('name', __('Name:')) !!}
        {!! Form::text('name', null, ['class'=> classValidOrInvalidForInput('name',$errors)]) !!}
        <div class="invalid-feedback">
            @if($errors->has('name'))
                @foreach($errors->get('name') as $msg)
                {{$msg}}<br/>
                @endforeach
            @endif
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('email', __('E-mail:')) !!}
        {!! Form::text('email', null, ['class'=> classValidOrInvalidForInput('email',$errors)]) !!}
        <div class="invalid-feedback">
            @if($errors->has('email'))
                @foreach($errors->get('email') as $msg)
                {{$msg}}<br/>
                @endforeach
            @endif
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('password', __('Password:')) !!}
        {!! Form::text('password', null, ['class'=> classValidOrInvalidForInput('password',$errors)]) !!}
        <div class="invalid-feedback">
            @if($errors->has('password'))
                @foreach($errors->get('password') as $msg)
                {{$msg}}<br/>
                @endforeach
            @endif
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('password_confirmation', __('Confirm password:')) !!}
        {!! Form::text('password_confirmation', null, ['class'=> classValidOrInvalidForInput('password_confirmation',$errors)]) !!}
        <div class="invalid-feedback">
            @if($errors->has('password_confirmation'))
                @foreach($errors->get('password_confirmation') as $msg)
                {{$msg}}<br/>
                @endforeach
            @endif
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('roles', __('Roles:')) !!}
        {!! Form::select('roles[]', $roles,[], ['class' => classValidOrInvalidForInput('roles[]',$errors),'multiple']) !!}
        <div class="invalid-feedback">
            @if($errors->has('roles'))
                @foreach($errors->get('roles') as $msg)
                {{$msg}}<br/>
                @endforeach
            @endif
        </div>
    </div>
    <div class="form-group text-rigth">
        {!! Form::submit('Save', ['class'=>'btn btn-danger']) !!}
        <a class="btn btn-primary" href="{{ route('usuarios.index') }}"> Back</a>
    </div>
    {!! Form::close() !!}
</div>
@endsection
