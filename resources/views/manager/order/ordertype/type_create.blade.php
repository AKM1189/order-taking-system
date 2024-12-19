@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/type" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-4">Add Order Type</h3>
        <div class="form col-md-6 p-0">
            <form action="/manager/type/create" method="POST">
            @csrf
            @method('PUT')
                <label class="form-label" for='typename'>Order Type Name</label>
                <input class="form-control mb-3" type='text' name='typename' id='typename' required>
                <input type='submit' class="btn btn-danger" value='Add'>
            </form> 
        </div>
    </div>
</div>
@endsection
