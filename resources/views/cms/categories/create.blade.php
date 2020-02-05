@extends($layout)

@section('content')
<div class="row h-10">
    <div class="col-12">
        <div class="pt-4 pb-2 border-bottom">
            <h1 class="h2">{{__('New Category')}}</h1>
        </div>
    </div>

    <div class="col-12 col-sm-9 mx-auto mt-4">
        {!! Form::open(array('route' => 'categorias.store')) !!}
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
</div>
@endsection
