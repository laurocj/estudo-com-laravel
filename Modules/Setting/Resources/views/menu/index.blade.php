@extends($_keyLayout)

@section($_keyContent)
    <x-table-index title="Menu" :route-new="route('menus.create')" :source="$menus">
        <x-slot name="thead">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($menus as $menu)
            <tr>
                <th scope="row">{{$menu->id}}</th>
                <td>{{$menu->name}}</td>
                <td>
                    <a href="{{route('menus.edit',$menu->id)}}" class='btn btn-primary btn-sm'>Edit</a>

                    @destroy(['route' => route('menus.destroy',$menu->id)])
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-table-index>
@endsection
