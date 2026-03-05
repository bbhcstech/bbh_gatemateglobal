@extends('admin.layout.app')

@section('title','View Amenity')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h5 class="mb-0">Amenity Details</h5>
            <a href="{{ route('amenities.index') }}" class="btn btn-sm btn-secondary">
                ← Back
            </a>
        </div>

        <!-- Body -->
        <div class="card-body">
            <div class="row g-4">

                <!-- Left Section -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="text-muted small">Amenity Name</label>
                        <h6 class="fw-semibold">{{ $amenity->name }}</h6>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Location</label>
                        <h6>{{ $amenity->location }}</h6>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Description</label>
                        <p class="mb-0">{{ $amenity->description ?? '—' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Rules</label>
                        <p class="mb-0">{{ $amenity->rules ?? '—' }}</p>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="col-md-4">
                    <div class="card bg-light border-0">
                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Capacity</span>
                                <span class="fw-semibold">{{ $amenity->capacity }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Booking Fee</span>
                                <span class="fw-semibold">
                                    ₹{{ number_format($amenity->booking_fee, 2) }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Status</span>
                                <span class="badge {{ $amenity->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $amenity->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Created</span>
                                <span class="fw-semibold">
                                    {{ $amenity->created_at->format('d M Y') }}
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Image -->
            @if($amenity->image)
            <hr>
            <div class="mt-3">
                <label class="text-muted small d-block mb-2">Amenity Image</label>
                <img src="{{ asset('storage/amenities/'.$amenity->image) }}"
                     class="img-fluid rounded border"
                     style="max-height: 250px;">
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="card-footer bg-white text-end">
            <a href="{{ route('amenities.edit', $amenity->id) }}"
               class="btn btn-warning btn-sm">
                ✏️ Edit
            </a>
        </div>

    </div>
</div>
@endsection
