@extends('admin.layout.app')

@section('title','Add Tower')

@section('content')
<div class="card">
    <div class="card-header">Add Tower</div>

    <div class="card-body">
        <form method="POST" action="{{ route('towers.store') }}">
            @csrf

            <div class="mb-3">
                <label>Tower Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Total Floors</label>
                <input type="number" name="total_floors" class="form-control">
            </div>

            <button class="btn btn-success">Save</button>
        </form>
    </div>
</div>
@endsection
