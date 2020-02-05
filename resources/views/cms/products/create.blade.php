@extends($layout)

@section('content')
<div class="row h-10">
    <div class="col-12">
        <div class="pt-4 pb-2 border-bottom">
            <h1 class="h2">{{__('New Products')}}</h1>
        </div>
    </div>

    <div class="col-12 col-sm-9 mx-auto mt-4">
        {!! Form::open(['route' => 'produtos.store','files'=>true]) !!}
        <div class="form-group">
                {!! Form::label('name', __('Title:')) !!}
                {!! Form::text('name', null, ['class'=> classValidOrInvalidForInput('name',$errors)]) !!}
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
                {!! Form::label('stock', __('Stock:')) !!}
                {!! Form::number('stock', null, ['class'=> classValidOrInvalidForInput('stock',$errors)] ) !!}
                <div class="invalid-feedback">
                    @if($errors->has('stock'))
                        @foreach($errors->get('stock') as $msg)
                        {{$msg}}<br/>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('price', __('Price:')) !!}
                {!! Form::number('price', null, ['class'=> classValidOrInvalidForInput('price',$errors), 'step'=>'0.01'] ) !!}
                <div class="invalid-feedback">
                    @if($errors->has('price'))
                        @foreach($errors->get('price') as $msg)
                        {{$msg}}<br/>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('category_id', __('Category:')) !!}
                {!! Form::select('category_id', $categories, null,['class'=> classValidOrInvalidForInput('category_id',$errors)] ) !!}
                <div class="invalid-feedback">
                    @if($errors->has('category_id'))
                        @foreach($errors->get('category_id') as $msg)
                        {{$msg}}<br/>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="form-group text-right">
                {!! Form::submit('Save', array( 'class'=>'btn btn-danger' )) !!}
                <a class="btn btn-primary" href="{{ route('produtos.index') }}"> Back</a>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
