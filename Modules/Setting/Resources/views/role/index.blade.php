@extends($_keyLayout)

@section($_keyContent)
    <x-table-index title="Role" :route-new="route('roles.create')" :source="$roles">
        <x-slot name="thead">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($roles as $role)
            <tr>
                <th scope="row">{{$role->id}}</th>
                <td>{{$role->name}}</td>
                <td>
                    <a href="{{route('roles.edit',$role->id)}}" class='btn btn-primary btn-sm'>Edit</a>

                    @destroy(['route' => route('roles.destroy',$role->id)])
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-table-index>
@endsection
