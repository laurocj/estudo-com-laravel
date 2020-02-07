@extends($layout)

@section('content')
<div class="row h-10">
    <div class="col-12">
        <div class="pt-4 pb-2 border-bottom">
            <h1 class="h2">{{__('Edit New Role')}}</h1>
        </div>
    </div>

    <div class="col-12 col-sm-9 mx-auto mt-4">
        {!! Form::model($role, ['method' => 'PATCH','route' => ['regras.update', $role->id]]) !!}
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

        <div class="form-group">
            <strong>Permission:</strong>

            @php
                $namePermission = '';
            @endphp

            @foreach($permissions as $key => $permission)
                @php
                    $arrNamePermission = explode('-',$permission->name);

                    if($arrNamePermission[0] !== $namePermission){
                        $namePermission = $arrNamePermission[0];
                        echo '<br>'.$arrNamePermission[0];
                    }
                @endphp

                <div class="form-check">
                    <label class='form-check-label'>
                        {!! Form::checkbox('permissions[]', $permission->id, $rolePermissions, array('class'=> classValidOrInvalidForCheck('permissons',$errors))) !!}
                        {{ $arrNamePermission[1] }}
                    </label>
                </div>
            @endforeach

            <div class="invalid-feedback">
                @if($errors->has('permissions'))
                    @foreach($errors->get('permissions') as $msg)
                    {{$msg}}<br/>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="form-group text-rigth">
            {!! Form::submit('Save', array( 'class'=>'btn btn-danger' )) !!}
            <a class="btn btn-primary" href="{{ route('regras.index') }}"> Back</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
