@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/table" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-4">Add Table</h3>
        <div class="form col-6">
        <form action="/manager/table/create" method="POST">
        @csrf
        @method('PUT')
            <label for='tablenumber' class="form-label">Table Number</label>
            <input type='text' name='tablenumber' class="form-control" id='tablenumber' required>

            <label for='capacity' class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" id="capacity" min="0" max="15" required>

            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="">Choose Status</option>
                <option value="Available">Available</option>
                <option value="Occupied">Occupied</option>
                <option value="Reserved">Reserved</option>
            </select>
            <input type='submit' class="btn btn-danger mt-3" value='Add'>
        </form>
@endsection
