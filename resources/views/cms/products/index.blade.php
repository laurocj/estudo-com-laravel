@extends($_keyLayout)

@section($_keyContent)
<div class="col-12">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 border-bottom">
        <h1 class="h2">{{__('Products')}}</h1>
        @can('product-create')
            <a href="{{ route('produtos.create') }}" class="btn btn-outline-success">{{__('New')}}</a>
        @endcan
    </div>

    <table class="table table-ordered ">
        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->category->name ?? ''}}</td>
                    <td>
                        <a href="{{route('produtos.edit',$product->id)}}" class='btn btn-primary btn-sm '>Edit</a>
                        {!! Form::open(array('route' => ['produtos.destroy',$product->id],'method' => 'delete','class'=>'d-inline')) !!}
                        {!! Form::submit(__('Delete'), array( 'class'=>'btn btn-danger btn-sm' )) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="align-self-end w-100 bg-light pt-2">
    <div class="d-flex justify-content-center">
        {!! $products->links() !!}
    </div>
</div>
@endsection

