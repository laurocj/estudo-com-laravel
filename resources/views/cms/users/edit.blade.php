@extends($_keyLayout)

@section($_keyContent)
<form action="{{ route('usuarios.update', $user->id) }}" method="post" class="card">
    @csrf
    @method('PUT')
    <div class="card-header">
        <div class="row">
            <div class="col-sm-12 col-md">
                <h1 class="h2 mb-0">{{__('Edit User')}}</h1>
            </div>
            <div class="col-sm-12 col-md-auto pt-2">
                <button type="submit" class="btn btn-sm btn-danger">{{ __("Save") }}</button>
                <a class="btn btn-sm btn-primary" href="{{ route('usuarios.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="card-body">
        @input([
            'label' => 'Name:',
            'type' => 'text',
            'name' => 'name',
            'value' => $user->name
        ])

        @input([
            'label' => 'E-mail:',
            'type' => 'text',
            'name' => 'email',
            'value' => $user->email
        ])

        @input([
            'label' => 'Password:',
            'type' => 'text',
            'name' => 'password'
        ])

        @input([
            'label' => __('Confirm password:'),
            'type' => 'text',
            'name' => 'password_confirmation'
        ])

        @foreach ($roles as $id => $name)
            @check([
            'type' => 'checkbox',
            'name' => "roles[$id]",
            'label' => $name,
            'value' => $id,
            'elements' => old("roles[$id]") ? 'checked' : (in_array($id,$userRole) ? "checked" : "")
            ])
        @endforeach
    </div>
</form>
@endsection
