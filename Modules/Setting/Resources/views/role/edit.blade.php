@extends($_keyLayout)

@section($_keyContent)
<form action="{{ route('roles.update',$role->id) }}" class="card" method="post">
    @method('put')
    @csrf
    <div class="card-header">
        <div class="row">
            <div class="col-sm-12 col-md">
                <h1 class="h2 mb-0">{{__('Edit Role')}}</h1>
            </div>
            <div class="col-sm-12 col-md-auto pt-2">
                <button type="submit" class="btn btn-sm btn-danger">{{ __("Save") }}</button>
                <a class="btn btn-sm btn-primary" href="{{ route('roles.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @input([
                'label' => 'Title:',
                'type' => 'text',
                'name' => 'name',
                'value' => old('name') ?? $role->name
            ])

        @input([
            'label' => 'Description:',
            'type' => 'text',
            'name' => 'description',
            'value' => old('description') ?? $role->description
        ])
    </div>
</form>
@endsection
