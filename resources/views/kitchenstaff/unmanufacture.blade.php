@extends('Layout.kitchen_layout')
@section('content')

<div class="p-sm-5 p-3 my-3">
    <h3>Uncook Menu</h3>
    <p>Menu Name - {{$menu->menuname}}</p>
    <p>Stock - {{$menu->quantity}}</p>
    <p>Price - {{$menu->price}}</p>
    <p>Status - {{$menu->status}}</p>
    <p>Menu Type - {{$menu->menu_type}}</p>


    <div class="table-responsive col-lg-8">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item Name</th>
                    <th>Stock</th>
                    <th>Consumption</th>
                    <th>Unit</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ingredients as $key=>$ingredient)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$ingredient->itemname}}</td>
                    <td>{{$ingredient->quantity}}</td>
                    <td>{{$ingredient->pivot->quantity}}</td>
                    <td>{{$ingredient->unit}}</td>
                    <td>{{$ingredient->pivot->subtotal}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <form action="/kitchen/unmanufacture/{{$menu->id}}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-sm-6 col-lg-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" class="form-control" name="quantity" placeholder="Enter menu quantity" required>
        </div>
        <input type="submit" class="btn btn-danger mt-3" value="Uncook">
        </form>
</div>
@endsection