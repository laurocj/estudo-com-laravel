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
                        {{ Form::text('name', null, ['class'=>'form-control']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::submit(__('Save'), array( 'class'=>'btn btn-danger form-control' )) }}
                    </div>
                {{ Form::close() }}
                <div class="alert-warning">
                    @foreach( $errors->all() as $error )
                    <br> {{ $error }}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection