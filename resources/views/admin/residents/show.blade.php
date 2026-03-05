@extends('admin.layout.app')

@section('title', 'Resident Details')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">👤 Resident Details</h4>
        <a href="{{ route('residents.index') }}" class="btn btn-outline-secondary">
            ← Back
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <div class="row g-4">

                <div class="col-md-6">
                    <label class="text-muted">Full Name</label>
                    <div class="fw-semibold">{{ $resident->name }}</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted">Resident Type</label>
                    <div>
                        <span class="badge bg-{{ $resident->type === 'owner' ? 'success' : 'info' }}">
                            {{ ucfirst($resident->type) }}
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted">Phone</label>
                    <div>{{ $resident->phone }}</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted">Email</label>
                    <div>{{ $resident->email ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted">Tower</label>
                    <div class="fw-semibold">
                        {{ $resident->flat->floor->tower->name }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted">Floor</label>
                    <div class="fw-semibold">
                        Floor {{ $resident->flat->floor->floor_no }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted">Flat Number</label>
                    <div class="fw-semibold">
                        {{ $resident->flat->flat_no }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted">Created At</label>
                    <div>
                        {{ $resident->created_at->format('d M Y, h:i A') }}
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection
