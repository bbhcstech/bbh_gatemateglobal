@extends('admin.layout.app')

@section('title','Edit Amenity')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Amenity</h5>
    </div>

    <form method="POST"
          action="{{ route('amenities.update', $amenity->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body row g-3">

            <div class="col-md-6">
                <label class="form-label">Amenity Name *</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $amenity->name) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Booking Fee (₹) *</label>
                <input type="number" name="booking_fee" class="form-control"
                       value="{{ old('booking_fee', $amenity->booking_fee) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Location *</label>
                <input type="text" name="location" class="form-control"
                       value="{{ old('location', $amenity->location) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Capacity *</label>
                <input type="number" name="capacity" class="form-control"
                       value="{{ old('capacity', $amenity->capacity) }}">
            </div>

            <div class="col-md-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $amenity->description) }}</textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label">Rules & Guidelines</label>
                <textarea name="rules" class="form-control" rows="3">{{ old('rules', $amenity->rules) }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Active</label><br>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox"
                           name="is_active"
                           {{ old('is_active', $amenity->is_active) ? 'checked' : '' }}>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Amenity Image</label>
                <input type="file" name="image" class="form-control">

                @if($amenity->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/'.$amenity->image) }}"
                             height="70" class="rounded border">
                    </div>
                @endif
            </div>

        </div>

        <div class="card-footer text-end">
            <button class="btn btn-primary">💾 Update</button>
            <a href="{{ route('amenities.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
