@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/table" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-4">Update Table</h3>
        <div class="form col-6">
        <form action="/manager/table/update/{{$table->id}}" method="POST">
        @csrf
        @method('PUT')

            <label for='tablenumber' class="form-label">Table Number</label>
            <input type='text' name='tablenumber' class="form-control" id='tablenumber' value='{{$table->tablenumber}}' required>

            <label for='capacity' class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" id="capacity" min="0" max="15" value='{{$table->capacity}}' required>

            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" value='{{$table->status}}' required>
                <option value="">Choose Status</option>
                <option value="Available" @if($table->status=='Available') selected @endif>Available</option>
                <option value="Occupied" @if($table->status=='Occupied') selected @endif>Occupied</option>
                <option value="Reserved" @if($table->status=='Reserved') selected @endif>Reserved</option>
            </select>
            <input type='submit' class="btn btn-danger mt-3" value='Update'>
        </form>
@endsection
