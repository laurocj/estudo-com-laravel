@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{ __('Edit Products') }}
            </div>
            <div class="card-body">
                {{ Form::model($product,['route' => ['produtos.update',$product->id],'files'=>true,'method'=>'put']) }}
                    <div class="form-group">
                        {{ Form::label('name', __('Title:')) }}
                        {{ Form::text('name', null, ['class'=>'form-control']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('stock', __('Stock:')) }}
                        {{ Form::number('stock', null, ['class'=>'form-control'] ) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('price', __('Price:')) }}
                        {{ Form::number('price', null, ['class'=>'form-control', 'step'=>'0.01'] ) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('category_id', __('Category:')) }}
                        {{ Form::select('category_id', $categories, null,['class'=>'form-control',] ) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('image', 'Choose an image') }}
                        {{ Form::file('image') }}
                    </div>

                    <div class="form-group">
                        {{ Form::submit('Save', array( 'class'=>'btn btn-danger form-control' )) }}
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