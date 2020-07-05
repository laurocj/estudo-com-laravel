@extends($_keyLayout)

@section($_keyContent)
    <x-table-index title="Action" :route-new="route('actions.create')" :source="$actions">
        <x-slot name="thead">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($actions as $action)
            <tr>
                <th scope="row">{{$action->id}}</th>
                <td>{{$action->name}}</td>
                <td>
                    <a href="{{route('actions.edit',$action->id)}}" class='btn btn-primary btn-sm'>Edit</a>

                    @destroy(['route' => route('actions.destroy',$action->id)])
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-table-index>
@endsection
