@extends('admin.layout.app')

@section('title', 'All Residents\' Vehicles')

@section('content')
<style>
    /* Page Header */
    .page-header {
        background: white;
        border-radius: 16px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-title h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .header-title p {
        color: #64748b;
        font-size: 0.875rem;
        margin: 0;
    }

    /* Back Button */
    .back-button {
        background-color: #64748b;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .back-button:hover {
        background-color: #475569;
        color: white;
    }

    /* Main Card */
    .main-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .card-header {
        background: white;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .card-header h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .total-badge {
        background-color: #64748b;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Table */
    .table-responsive {
        padding: 1.5rem;
        overflow-x: auto;
    }

    .vehicle-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.5rem;
        min-width: 1000px;
    }

    .vehicle-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .vehicle-table tbody tr {
        background: white;
        border-radius: 12px;
        transition: all 0.2s;
    }

    .vehicle-table tbody tr:hover {
        background: #f8fafc;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .vehicle-table tbody td {
        padding: 1rem;
        color: #1e293b;
        font-size: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    /* Vehicle Image */
    .vehicle-thumb {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid #e2e8f0;
    }

    .vehicle-thumb-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        border: 2px solid #e2e8f0;
    }

    /* Status Badge */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .status-active {
        background: #d1fae5;
        color: #059669;
    }

    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    /* Vehicle Type Badge */
    .vehicle-type-badge {
        background: #e2e8f0;
        color: #475569;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        font-size: 0.7rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        margin-left: 0.25rem;
    }

    /* Parking Info */
    .parking-info {
        font-size: 0.7rem;
        color: #64748b;
        background: #f1f5f9;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        display: inline-block;
        margin-top: 0.15rem;
    }

    .parking-info i {
        margin-right: 0.25rem;
        color: #2563eb;
    }

    /* View Button */
    .btn-view {
        background: #2563eb;
        color: white;
        border: none;
        padding: 0.4rem 1rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-view:hover {
        background: #1d4ed8;
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
    }

    .empty-icon {
        font-size: 3rem;
        color: #e2e8f0;
        margin-bottom: 1rem;
    }

    .empty-state h6 {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }

    /* Modal */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    }

    .modal-header {
        background: white;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem;
    }

    .modal-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .modal-body {
        padding: 1.5rem;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="header-title">
            <h2>
                <i class="fas fa-car me-2" style="color: #2563eb;"></i>
                All Residents' Vehicles
            </h2>
            <p>View all vehicles registered in the society</p>
        </div>
        <div>
            <a href="{{ route('vehicles.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to My Vehicles
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-list"></i>
                All Vehicles Directory
            </h5>
            <span class="total-badge">
                <i class="fas fa-car me-1"></i>
                Total: {{ $vehicles->count() }}
            </span>
        </div>

        <div class="table-responsive">
            @if($vehicles->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h6>No vehicles found in the society</h6>
                </div>
            @else
                <table class="vehicle-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Vehicle Details</th>
                            <th>Owner</th>
                            <th>Flat</th>
                            <th>Parking Slot</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $key => $vehicle)
                            <tr>
                                <td>
                                    <span style="color: #64748b;">{{ $key + 1 }}</span>
                                </td>
                                <td>
                                    @if($vehicle->vehicle_image && file_exists(public_path($vehicle->vehicle_image)))
                                        <img src="{{ asset($vehicle->vehicle_image) }}"
                                             class="vehicle-thumb"
                                             onclick="previewImage('{{ asset($vehicle->vehicle_image) }}')"
                                             alt="Vehicle"
                                             onerror="this.onerror=null; this.src='{{ asset('images/default-vehicle.png') }}';"
                                             style="cursor: pointer;">
                                    @else
                                        <div class="vehicle-thumb-placeholder">
                                            <i class="fas fa-car"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600;">
                                        {{ $vehicle->vehicle_number }}
                                        <span class="vehicle-type-badge">
                                            <i class="fas fa-{{ str_contains(strtolower($vehicle->vehicle_type ?? ''), 'bike') ? 'motorcycle' : 'car' }}"></i>
                                            {{ $vehicle->vehicle_type ?? 'N/A' }}
                                        </span>
                                    </div>
                                    <div style="font-size: 0.75rem; color: #64748b;">
                                        @if($vehicle->make)
                                            {{ $vehicle->make }}
                                        @endif
                                        @if($vehicle->model)
                                            {{ $vehicle->model }}
                                        @endif
                                        @if($vehicle->color)
                                            • {{ $vehicle->color }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 500;">{{ $vehicle->resident->name ?? $vehicle->owner_name ?? 'N/A' }}</div>
                                    @if($vehicle->sticker_number)
                                        <div class="parking-info">
                                            <i class="fas fa-tag"></i>
                                            Sticker: {{ $vehicle->sticker_number }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($vehicle->resident && $vehicle->resident->flat)
                                        <span style="font-weight: 500;">{{ $vehicle->resident->flat->flat_no ?? 'N/A' }}</span>
                                        <div style="font-size: 0.7rem; color: #64748b;">
                                            {{ $vehicle->resident->flat->tower ?? '' }}
                                        </div>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($vehicle->parkingSlot)
                                        <span class="parking-info">
                                            <i class="fas fa-parking"></i>
                                            {{ $vehicle->parkingSlot->parking_no ?? 'N/A' }}
                                        </span>
                                        <div style="font-size: 0.7rem; color: #64748b; margin-top: 0.25rem;">
                                            {{ $vehicle->parkingSlot->type ?? '' }}
                                        </div>
                                    @else
                                        <span style="color: #94a3b8;">Not assigned</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = $vehicle->status ?? 'pending';
                                        $statusClass = match($status) {
                                            'active', 'approved' => 'status-active',
                                            'inactive', 'rejected' => 'status-inactive',
                                            default => 'status-pending'
                                        };
                                        $statusIcon = match($status) {
                                            'active', 'approved' => 'fa-check-circle',
                                            'inactive', 'rejected' => 'fa-times-circle',
                                            default => 'fa-clock'
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        <i class="fas {{ $statusIcon }}"></i>
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn-view">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image me-2"></i>
                    Vehicle Image
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" class="img-fluid rounded" style="max-height: 250px;">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let imageModal;

    document.addEventListener('DOMContentLoaded', function() {
        imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    });

    function previewImage(src) {
        document.getElementById('modalImage').src = src;
        imageModal.show();
    }
</script>
@endpush
