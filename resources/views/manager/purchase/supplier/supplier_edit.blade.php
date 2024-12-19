@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/supplier" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-4">Update Supplier</h3>

        <div class="col-md-6 p-0">
            <form action="/manager/supplier/update/{{$supplier->id}}" method="POST">
                @csrf
                @method('PUT')
        
                <label class="form-label" for='name'>Supplier Name</label>
                <input class="form-control" type='text' name='name' id='name' value='{{$supplier->name}}' required>
        
                <label class="form-label" for='phone'>Phone</label>
                <input class="form-control" type="phone" name="phone" value='{{$supplier->phone}}' id="phone" required>
        
                <label class="form-label" for='email'>Email</label>
                <input class="form-control" type="email" name="email" value='{{$supplier->email}}' id="email" required>
        
                <label class="form-label" for='address'>Address</label>
                <input class="form-control" type="address" name="address" value='{{$supplier->address}}' id="address" required>
        
        
                <input class="btn btn-danger mt-3" type='submit' value='Update'>
                </form>
        </div>
    </div>
</div>
@endsection
