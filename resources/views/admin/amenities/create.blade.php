@extends('admin.layout.app')

@section('title','Add Amenity')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Add Amenity</h5>
    </div>

    <form method="POST" action="{{ route('amenities.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card-body row g-3">

            <div class="col-md-6">
                <label class="form-label">Amenity Name *</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Booking Fee (₹) *</label>
                <input type="number" name="booking_fee" class="form-control" value="0">
            </div>

            <div class="col-md-6">
                <label class="form-label">Location *</label>
                <input type="text" name="location" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Capacity *</label>
                <input type="number" name="capacity" class="form-control" value="1">
            </div>

            <div class="col-md-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label">Rules & Guidelines</label>
                <textarea name="rules" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Active</label><br>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" checked>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Amenity Image</label>
                <input type="file" name="image" class="form-control">
                <small class="text-muted">
                    Max size: 5MB. Allowed formats: JPG, PNG, GIF
                </small>
            </div>

        </div>

        <div class="card-footer text-end">
            <button class="btn btn-primary">💾 Save</button>
            <a href="{{ route('amenities.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
