@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/supplier" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-4">Add Supplier</h3>

        <div class="form col-md-6 p-0">
            <form action="/manager/supplier/create" method="POST">
                @csrf
                @method('PUT')
                    <label class="form-label" for='name'>Supplier Name</label>
                    <input class="form-control" type='text' name='name' id='name' required>
        
                    <label class="form-label" for='phone'>Phone</label>
                    <input class="form-control" type="phone" name="phone" id="phone" required>
        
                    <label class="form-label" for='email'>Email</label>
                    <input class="form-control" type="email" name="email" id="email" required>
        
                    <label class="form-label" for='address'>Address</label>
                    <input class="form-control" type="address" name="address" id="address" required>
        
        
                    <input class="btn btn-danger mt-3" type='submit' value='Add'>
                </form>
        </div>
    </div>
</div>
@endsection
