@extends($layout)

@section('content')
<div class="col-12">
    <div class="pt-4 pb-2 border-bottom">
        <h1 class="h2">{{__('Edit Category')}}</h1>
    </div>
</div>

<div class="col-12 col-sm-9 mx-auto mt-4">
    {!! Form::model($category, array('route' => ['categorias.update',$category->id],'method' => 'put' )) !!}
        <div class="form-group">
            {!! Form::label('name', __('Title:')) !!}
            {!! Form::text('name', null, ['class'=> classValidOrInvalidForInput('name',$errors)]) !!}
            <div class="invalid-feedback">
                @if($errors->has('name'))
                    @foreach($errors->get('name') as $msg)
                    {{$msg}}<br/>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="form-group text-right">
            {!! Form::submit('Save', array( 'class'=>'btn btn-danger' )) !!}
            <a class="btn btn-primary" href="{{ route('categorias.index') }}"> Back</a>
        </div>
    {!! Form::close() !!}
</div>
@endsection
