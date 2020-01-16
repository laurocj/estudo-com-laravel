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
                {{ __('New Products') }}
            </div>
            <div class="card-body">
                {{ Form::open(['route' => 'produtos.store','files'=>true]) }}
                    <div class="form-group">
                        {{ Form::label('name', __('Title:')) }}
                        {{ Form::text('name', null, ['class'=> getClassList('name',$errors)]) }}
                        <small id="nameHelp" class="form-text text-muted">Name of product.</small>
                        <div class="invalid-feedback">
                            @if($errors->has('name'))
                                @foreach($errors->get('name') as $msg)
                                {{$msg}}<br/>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('stock', __('Stock:')) }}
                        {{ Form::number('stock', null, ['class'=> getClassList('stock',$errors)] ) }}
                        <div class="invalid-feedback">
                            @if($errors->has('stock'))
                                @foreach($errors->get('stock') as $msg)
                                {{$msg}}<br/>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('price', __('Price:')) }}
                        {{ Form::number('price', null, ['class'=> getClassList('price',$errors), 'step'=>'0.01'] ) }}
                        <div class="invalid-feedback">
                            @if($errors->has('price'))
                                @foreach($errors->get('price') as $msg)
                                {{$msg}}<br/>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('category_id', __('Category:')) }}
                        {{ Form::select('category_id', $categories, null,['class'=>getClassList('category_id',$errors)] ) }}
                        <div class="invalid-feedback">
                            @if($errors->has('category_id'))
                                @foreach($errors->get('category_id') as $msg)
                                {{$msg}}<br/>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::submit('Save', array( 'class'=>'btn btn-danger' )) }}
                        <a class="btn btn-primary" href="{{ route('produtos.index') }}"> Back</a>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection