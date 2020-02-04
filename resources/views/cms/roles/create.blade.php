<?php
    function getClassList($field,$errors) {
        if($errors->has($field))
            return ' form-control is-invalid ';

        if(old($field) !== null)
            return ' form-control is-valid ';

        return ' form-control ';
    }

    function getCheckClassList($field,$errors) {
        if($errors->has($field))
            return ' form-check-input is-invalid ';

        if(old($field) !== null)
            return ' form-check-input is-valid ';

        return ' form-check-input ';
    }
?>
@extends($layout)


@section('content')
<div class="container">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{__('Create New Role')}}
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => 'regras.store','method'=>'POST')) !!}
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
                    <strong>Permission:</strong>

                    @foreach($permission as $value)
                        <div class="form-check">
                            <label class='form-check-label'>
                                {{ Form::checkbox('permission[]', $value->id, false, array('class' => getCheckClassList('permisson',$errors))) }}
                            {{ $value->name }}
                            </label>
                        </div>
                    @endforeach

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
                    <a class="btn btn-primary" href="{{ route('regras.index') }}"> Back</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection