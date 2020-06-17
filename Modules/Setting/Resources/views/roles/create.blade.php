@extends($_keyLayout)

@section($_keyContent)
<form action="{{ route('regras.store') }}" method="post" class="card">
    @csrf
    <div class="card-header">
        <div class="row">
            <div class="col-sm-12 col-md">
                <h1 class="h2 mb-0">{{__('Create New Roles')}}</h1>
            </div>
            <div class="col-sm-12 col-md-auto pt-2">
                <button type="submit" class="btn btn-sm btn-danger">{{ __("Save") }}</button>
                <a class="btn btn-sm btn-primary" href="{{ route('regras.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="card-body">
        @input([
            'label' => 'Name:',
            'type' => 'text',
            'name' => 'name'
        ])

        @foreach ($permissions as $id => $name)
            @check([
            'type' => 'checkbox',
            'name' => 'permissions',
            'label' => $name,
            'value' => $id,
            'elements' => old("permissions[$id]") ? 'checked' : ''
            ])
        @endforeach
    </div>
</form>
@endsection
