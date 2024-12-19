@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/material" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-4">Update Ingredient</h3>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <li>{{ $errors->first() }}</li>
            </ul>
        </div>
    @endif

        <div class="col-md-6">
            <form action="/manager/material/update/{{$material->id}}" method="POST">
                @csrf
                @method('PUT')
                    <label for='itemname' class="form-label">Item Name</label>
                    <input type='text' name='itemname' class="form-control" id='itemname' value='{{$material->itemname}}' required>
        
                    <label for='price' class="form-label">Price</label>
                    <input type="number" name="price" step="0.01" class="form-control" min=0 id="price" value='{{$material->price}}' required>
        
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number"  step="0.1" name="quantity" class="form-control" readonly id="quantity" value='{{$material->quantity}}' min="0" required>
        
                    <label for="unit" class="form-label">Unit</label>
                    <input type="string" name="unit" class="form-control" id="unit" value='{{$material->unit}}' required>
                    <input type='submit' class="btn btn-danger mt-3" value='Update'>
                </form>
        </div>
    </div>
</div>

@endsection
