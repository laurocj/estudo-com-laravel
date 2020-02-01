<?php
    function getClassList($field,$errors) {
        if($errors->has($field))
            return ' form-control is-invalid ';

        if(old($field) !== null)
            return ' form-control is-valid ';

        return ' form-control ';
    }
?>
@extends('cms.layouts.app')

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
                    {{ Form::text('name', null, ['class'=>getClassList('name',$errors)]) }}
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
                    {{ Form::text('email', null, ['class'=>getClassList('email',$errors)]) }}
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
                    {{ Form::text('password', null, ['class'=>getClassList('password',$errors)]) }}
                    <div class="invalid-feedback">
                        @if($errors->has('password'))
                            @foreach($errors->get('password') as $msg)
                            {{$msg}}<br/>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('confirm-password', __('Confirm password:')) }}
                    {{ Form::text('confirm-password', null, ['class'=>getClassList('confirm-password',$errors)]) }}
                    <div class="invalid-feedback">
                        @if($errors->has('confirm-password'))
                            @foreach($errors->get('confirm-password') as $msg)
                            {{$msg}}<br/>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('roles', __('Title:')) }}
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
                    <a class="btn btn-primary" href="{{ route('categorias.index') }}"> Back</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection