@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/role" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-4">Add Role</h3>
        <div class="form col-md-6 p-0">
            <form action="/manager/role/create" method="POST">
                @csrf
                @method('PUT')
                <label for='rolename' class="form-label">Role Name</label>
                <input type='text' name='rolename' class="form-control" id='rolename' required>
                <input type='submit' class="btn btn-danger mt-3" value='Add'>
            </form>
        </div>
    </div>
</div>
@endsection