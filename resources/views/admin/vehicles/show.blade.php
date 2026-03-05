@extends('admin.layout.app')

@section('title', 'View Vehicle')

@section('content')
<div class="container-fluid">

    <a href="{{ route('vehicles.index') }}" class="text-decoration-none mb-3 d-inline-block">
        ← Back to List
    </a>

    <div class="row g-4">

        <!-- LEFT : Vehicle Details -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">
                    View Vehicle
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        @foreach([
                            'Vehicle Number' => $vehicle->vehicle_number,
                            'Sticker Number' => $vehicle->sticker_number,
                            'Vehicle Type'   => ucfirst(str_replace('_',' ', $vehicle->vehicle_type)),
                            'Make'           => $vehicle->make,
                            'Model'          => $vehicle->model,
                            'Color'          => $vehicle->color,
                            'Parking Slot'   => $vehicle->parking_slot,
                        ] as $label => $value)
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ $label }}</label>
                            <input class="form-control" value="{{ $value ?? '-' }}" readonly>
                        </div>
                        @endforeach

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Owner</label>
                            <input class="form-control"
                                   value="{{ $vehicle->resident->name?? '-' }} ({{ $vehicle->resident->flat_no?? '-' }})"
                                   readonly>
                        </div>

                        <!-- Vehicle Image -->
                        <div class="col-md-12 text-center mt-3">
                            @if($vehicle->vehicle_image)
                                <img src="{{ asset($vehicle->vehicle_image) }}"
                                     class="rounded border"
                                     style="max-height:200px">
                            @else
                                <span class="badge bg-secondary">No Image</span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT : Information -->
        <div class="col-lg-4">

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white fw-semibold">
                    Vehicle Information
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong>
                        <span class="badge {{ $vehicle->is_approved ? 'bg-success' : 'bg-danger' }}">
                            {{ $vehicle->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                    </p>
                    <p><strong>Owner:</strong> {{ $vehicle->resident->name?? '-' }}</p>
                    <p><strong>Flat:</strong> {{ $vehicle->resident->flat_no?? '-' }}</p>
                    <p><strong>Registered:</strong> {{ $vehicle->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">
                    Quick Actions
                </div>
                <div class="card-body d-grid gap-2">

                    <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-outline-warning">
                        ✏ Edit Vehicle
                    </a>

                    <form action="{{ route('vehicles.status', $vehicle) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-outline-danger">
                            {{ $vehicle->is_approved ? 'Disapprove' : 'Approve' }}
                        </button>
                    </form>

                    <a href="{{ route('residents.show', $vehicle->resident_id) }}"
                       class="btn btn-outline-primary">
                        👤 View Owner
                    </a>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection
