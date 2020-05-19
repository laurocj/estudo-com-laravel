@extends($_keyLayout)

@section($_keyContent)
<x-table-index title="Users Management" :route-new="route('usuarios.create')" :source="$users">
    <x-slot name="thead">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Roles</th>
            <th scope="col">Action</th>
        </tr>
    </x-slot>
    <x-slot name="tbody">
        @foreach ($users as $key => $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                {{-- @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                    <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                @endif --}}
                </td>
                <td>
                <a class="btn btn-sm btn-info" href="{{ route('usuarios.show',$user->id) }}">Show</a>
                <a class="btn btn-sm btn-primary" href="{{ route('usuarios.edit',$user->id) }}">Edit</a>
                @destroy(['route' => route('usuarios.destroy',$user->id)])
                </td>
            </tr>
            @endforeach
    </x-slot>
</x-table-index>
@endsection


