@extends($_keyLayout)

@section($_keyContent)
    <x-table-index title="Permission" :route-new="route('permissions.create')" :source="$permissions">
        <x-slot name="thead">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($permissions as $permission)
            <tr>
                <th scope="row">{{$permission->id}}</th>
                <td>{{$permission->name}}</td>
                <td>
                    <a href="{{route('permissions.edit',$permission->id)}}" class='btn btn-primary btn-sm'>Edit</a>

                    @destroy(['route' => route('permissions.destroy',$permission->id)])
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-table-index>
@endsection
