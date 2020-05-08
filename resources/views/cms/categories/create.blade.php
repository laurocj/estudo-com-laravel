@extends($layout)

@section('content')
{!! Form::open(array('route' => 'categorias.store','class'=>'card')) !!}
    <div class="card-header">
        <div class="row">
            <div class="col-sm-12 col-md">
                <h1 class="h2 mb-0">{{__('New Category')}}</h1>
            </div>
            <div class="col-sm-12 col-md-auto pt-2">
                {!! Form::submit('Save', array( 'class'=>'btn btn-sm btn-danger' )) !!}
                <a class="btn btn-sm btn-primary" href="{{ route('categorias.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="card-body">
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
    </div>
{!! Form::close() !!}
@endsection
