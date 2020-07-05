@extends($_keyLayout)

@section($_keyContent)
    <x-table-index title="Acl" :route-new="route('acls.create')" :source="$acls">
        <x-slot name="thead">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($acls as $acl)
            <tr>
                <th scope="row">{{$acl->id}}</th>
                <td>{{$acl->name}}</td>
                <td>
                    <a href="{{route('acls.edit',$acl->id)}}" class='btn btn-primary btn-sm'>Edit</a>

                    @destroy(['route' => route('acls.destroy',$acl->id)])
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-table-index>
@endsection
