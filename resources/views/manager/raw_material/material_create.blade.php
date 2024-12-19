@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/material" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-4">Add Ingredient</h3>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <li>{{ $errors->first() }}</li>
            </ul>
        </div>
    @endif

        <div class="col-md-6 p-0">
            <form action="/manager/material/create" method="POST">
                @csrf
                @method('PUT')
                    <label for='itemname' class="form-label">Item Name</label>
                    <input type='text' class="form-control" name='itemname' id='itemname' required>
        
                    <label for='price' class="form-label">Price</label>
                    <input type="number" class="form-control" step="0.01" min="0" name="price" id="price" required>
        
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number"  step="0.1" class="form-control" value="0" readonly name="quantity" id="quantity" min="0" required>
        
                    <label for="unit" class="form-label">Unit</label>
                    <input type="string" class="form-control" name="unit" id="unit" required>
                    <input type='submit' class="btn btn-danger mt-3" value='Add'>
                </form>
        </div>
    </div>
</div>
@endsection
