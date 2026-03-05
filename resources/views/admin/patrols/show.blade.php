@extends('admin.layout.app')

@section('title','View Patrol')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">🚓 Patrol Details</h4>

        <div class="d-flex gap-2">
           

            <a href="{{ route('patrols.index') }}" class="btn btn-secondary btn-sm">
                ⬅ Back
            </a>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <div class="row g-4">

                {{-- Guard Info --}}
                <div class="col-md-6">
                    <div class="border rounded-3 p-3 h-100">
                        <h6 class="text-muted mb-2">👮 Guard</h6>
                        <h5 class="fw-semibold mb-0">
                            {{ $patrol->securityGuard?->name ?? 'Not Assigned' }}
                        </h5>
                    </div>
                </div>

                {{-- Zone Info --}}
                <div class="col-md-6">
                    <div class="border rounded-3 p-3 h-100">
                        <h6 class="text-muted mb-2">📍 Zone</h6>
                        <h5 class="fw-semibold mb-0">
                            {{ $patrol->zone?->name ?? '—' }}
                        </h5>
                    </div>
                </div>

                {{-- Time Info --}}
                <div class="col-md-6">
                    <div class="border rounded-3 p-3 h-100">
                        <h6 class="text-muted mb-2">⏰ Patrol Time</h6>
                        <p class="mb-1">
                            <strong>Start:</strong>
                            {{ \Carbon\Carbon::parse($patrol->start_time)->format('d M Y, h:i A') }}
                        </p>
                        <p class="mb-0">
                            <strong>End:</strong>
                            {{ $patrol->end_time
                                ? \Carbon\Carbon::parse($patrol->end_time)->format('d M Y, h:i A')
                                : 'Not Ended' }}
                        </p>
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <div class="border rounded-3 p-3 h-100">
                        <h6 class="text-muted mb-2">📌 Status</h6>
                        <span class="badge
                            @if($patrol->status === 'completed') bg-success
                            @elseif($patrol->status === 'ongoing') bg-primary
                            @else bg-secondary
                            @endif
                            px-3 py-2">
                            {{ ucfirst($patrol->status) }}
                        </span>
                    </div>
                </div>

                {{-- Checkpoints --}}
                <div class="col-12">
                    <div class="border rounded-3 p-3">
                        <h6 class="text-muted mb-2">📋 Checkpoints</h6>
                        <p class="mb-0">
                            {{ $patrol->checkpoints ?? 'No checkpoints recorded' }}
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection

