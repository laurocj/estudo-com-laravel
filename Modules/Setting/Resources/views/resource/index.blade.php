@extends($_keyLayout)

@section($_keyContent)
    <x-table-index title="Resource" :route-new="route('resources.create')" :source="$resources">
        <x-slot name="thead">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($resources as $resource)
            <tr>
                <th scope="row">{{$resource->id}}</th>
                <td>{{$resource->name}}</td>
                <td>
                    <a href="{{route('resources.edit',$resource->id)}}" class='btn btn-primary btn-sm'>Edit</a>

                    @destroy(['route' => route('resources.destroy',$resource->id)])
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-table-index>
@endsection
