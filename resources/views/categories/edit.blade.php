<?php
    function getClassList($field,$errors) {
        if($errors->has($field))
            return ' form-control is-invalid ';

        if(old($field) !== null)
            return ' form-control is-valid ';

        return ' form-control ';
    }
?>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{ __('Edit Category') }}
            </div>
            <div class="card-body">
                {{ Form::model($category, array('route' => ['categorias.update',$category->id],'method' => 'put' )) }}
                    <div class="form-group">
                        {{ Form::label('name', __('Title:')) }}
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
                        {{ Form::submit('Save', array( 'class'=>'btn btn-danger' )) }}
                        <a class="btn btn-primary" href="{{ route('categorias.index') }}"> Back</a>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection