@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/category" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-4">Update Category</h3>
        <div class="form col-6 p-0">
        <form action="/manager/category/update/{{$category->id}}" method="POST">
        @csrf
        @method('PUT')

            <label for='categoryname' class="form-label">Category Name</label>
            <input type='text' name='categoryname' class="form-control mb-3" id='categoryname' value='{{$category->categoryname}}' required>

            <input type='submit' class="btn btn-danger" value='Update'>
        </form>
        </div>
    </div>
</div>
@endsection
