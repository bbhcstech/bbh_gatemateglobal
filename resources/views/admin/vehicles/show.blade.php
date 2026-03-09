@extends('admin.layout.app')

@section('title', 'View Vehicle')

@section('content')
<style>
    .detail-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.05);
        background: white;
        margin-bottom: 24px;
    }

    .detail-card .card-header {
        background: white;
        border-bottom: 2px solid #0d6efd;
        padding: 16px 20px;
        border-radius: 12px 12px 0 0 !important;
    }

    .detail-card .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #0d6efd;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-card .card-body {
        padding: 24px;
    }

    .info-label {
        color: #6c757d;
        font-size: 0.85rem;
        margin-bottom: 4px;
        font-weight: 500;
    }

    .info-value {
        color: #212529;
        font-size: 1rem;
        font-weight: 500;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 8px;
    }

    .info-value:last-child {
        border-bottom: none;
    }

    .image-preview {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 4px;
        max-height: 200px;
        width: auto;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-active {
        background: #d1e7dd;
        color: #0f5132;
    }

    .status-inactive {
        background: #f8d7da;
        color: #842029;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-approved {
        background: #d1e7dd;
        color: #0f5132;
    }

    .status-rejected {
        background: #f8d7da;
        color: #842029;
    }

    .status-blacklisted {
        background: #2b2b2b;
        color: white;
    }

    .back-link {
        color: #6c757d;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .back-link:hover {
        color: #0d6efd;
        transform: translateX(-5px);
    }

    .action-btn {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        border: 1px solid transparent;
        margin-bottom: 10px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #ffc107;
        color: #000;
        border: none;
    }

    .btn-edit:hover {
        background: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        color: #000;
    }

    .btn-approve {
        background: #198754;
        color: white;
    }

    .btn-approve:hover {
        background: #157347;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
        color: white;
    }

    .btn-disapprove {
        background: #dc3545;
        color: white;
    }

    .btn-disapprove:hover {
        background: #bb2d3b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        color: white;
    }

    .btn-view-owner {
        background: #0d6efd;
        color: white;
    }

    .btn-view-owner:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        color: white;
    }

    .btn-archive {
        background: #6c757d;
        color: white;
        border: none;
    }

    .btn-archive:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        color: white;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Back Link -->
    <a href="{{ route('vehicles.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
        Back to Vehicle List
    </a>

    <div class="row g-4">
        <!-- LEFT COLUMN - Vehicle Details -->
        <div class="col-lg-8">
            <div class="detail-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-car"></i>
                        Vehicle Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <!-- Vehicle Number -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-hashtag me-1" style="color: #0d6efd;"></i>
                                Vehicle Number
                            </div>
                            <div class="info-value">{{ $vehicle->vehicle_number ?? '-' }}</div>
                        </div>

                        <!-- Sticker Number -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-tag me-1" style="color: #0d6efd;"></i>
                                Sticker Number
                            </div>
                            <div class="info-value">{{ $vehicle->sticker_number ?? '-' }}</div>
                        </div>

                        <!-- Vehicle Type -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-motorcycle me-1" style="color: #0d6efd;"></i>
                                Vehicle Type
                            </div>
                            <div class="info-value">{{ ucfirst(str_replace('_', ' ', $vehicle->vehicle_type)) ?? '-' }}</div>
                        </div>

                        <!-- Make -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-industry me-1" style="color: #0d6efd;"></i>
                                Make
                            </div>
                            <div class="info-value">{{ $vehicle->make ?? '-' }}</div>
                        </div>

                        <!-- Model -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-car me-1" style="color: #0d6efd;"></i>
                                Model
                            </div>
                            <div class="info-value">{{ $vehicle->model ?? '-' }}</div>
                        </div>

                        <!-- Color -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-palette me-1" style="color: #0d6efd;"></i>
                                Color
                            </div>
                            <div class="info-value">{{ $vehicle->color ?? '-' }}</div>
                        </div>

                        <!-- Parking Slot -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-parking me-1" style="color: #0d6efd;"></i>
                                Parking Slot
                            </div>
                            <div class="info-value">
                                @if($vehicle->parkingSlot)
                                    {{ $vehicle->parkingSlot->parking_no }}
                                    @if($vehicle->parkingSlot->type)
                                        ({{ $vehicle->parkingSlot->type }})
                                    @endif
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-shield-alt me-1" style="color: #0d6efd;"></i>
                                Status
                            </div>
                            <div class="info-value">
                                @php
                                    $statusClass = match($vehicle->status) {
                                        'active', 'approved' => 'status-active',
                                        'inactive' => 'status-inactive',
                                        'pending' => 'status-pending',
                                        'rejected' => 'status-rejected',
                                        'blacklisted' => 'status-blacklisted',
                                        default => 'status-pending'
                                    };
                                    $statusIcon = match($vehicle->status) {
                                        'active', 'approved' => 'fa-check-circle',
                                        'inactive' => 'fa-minus-circle',
                                        'pending' => 'fa-clock',
                                        'rejected' => 'fa-times-circle',
                                        'blacklisted' => 'fa-ban',
                                        default => 'fa-clock'
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    <i class="fas {{ $statusIcon }}"></i>
                                    {{ ucfirst($vehicle->status ?? 'pending') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Owner Information -->
                    <div class="mt-4">
                        <div class="info-label">
                            <i class="fas fa-user me-1" style="color: #0d6efd;"></i>
                            Owner Information
                        </div>
                        <div class="info-value">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Name:</strong> {{ $vehicle->resident->name ?? '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Flat:</strong>
                                    @if($vehicle->resident && $vehicle->resident->flat)
                                        {{ $vehicle->resident->flat->flat_no ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </div>
                                @if($vehicle->resident)
                                <div class="col-md-6 mt-2">
                                    <strong>Contact:</strong> {{ $vehicle->resident->phone ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mt-2">
                                    <strong>Email:</strong> {{ $vehicle->resident->email ?? 'N/A' }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Registration Information -->
                    <div class="mt-4">
                        <div class="info-label">
                            <i class="fas fa-calendar me-1" style="color: #0d6efd;"></i>
                            Registration Information
                        </div>
                        <div class="info-value">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Created:</strong> {{ $vehicle->created_at ? $vehicle->created_at->format('d M Y H:i') : '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Last Updated:</strong> {{ $vehicle->updated_at ? $vehicle->updated_at->format('d M Y H:i') : '-' }}
                                </div>
                                @if($vehicle->created_by)
                                <div class="col-md-6 mt-2">
                                    <strong>Created By:</strong> {{ $vehicle->creator->name ?? 'System' }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Image -->
                    @if($vehicle->vehicle_image && file_exists(public_path($vehicle->vehicle_image)))
                    <div class="mt-4 text-center">
                        <div class="info-label mb-3">Vehicle Image</div>
                        <img src="{{ asset($vehicle->vehicle_image) }}"
                             class="image-preview"
                             style="max-height: 200px;"
                             alt="Vehicle Image">
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN - Quick Actions & Info -->
        <div class="col-lg-4">
            <!-- Status Summary Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-info-circle"></i>
                        Quick Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="info-label">Current Status</div>
                        <div class="mt-2">
                            @php
                                $statusClass = match($vehicle->status) {
                                    'active', 'approved' => 'status-active',
                                    'inactive' => 'status-inactive',
                                    'pending' => 'status-pending',
                                    'rejected' => 'status-rejected',
                                    'blacklisted' => 'status-blacklisted',
                                    default => 'status-pending'
                                };
                                $statusIcon = match($vehicle->status) {
                                    'active', 'approved' => 'fa-check-circle',
                                    'inactive' => 'fa-minus-circle',
                                    'pending' => 'fa-clock',
                                    'rejected' => 'fa-times-circle',
                                    'blacklisted' => 'fa-ban',
                                    default => 'fa-clock'
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}" style="font-size: 1rem;">
                                <i class="fas {{ $statusIcon }}"></i>
                                {{ ucfirst($vehicle->status ?? 'pending') }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Owner</div>
                        <div class="fw-bold">{{ $vehicle->resident->name ?? '-' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Flat Number</div>
                        <div class="fw-bold">{{ $vehicle->resident->flat->flat_no ?? '-' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Registered On</div>
                        <div>{{ $vehicle->created_at ? $vehicle->created_at->format('d M Y') : '-' }}</div>
                    </div>

                    @if($vehicle->parkingSlot)
                    <div class="mb-3">
                        <div class="info-label">Assigned Parking</div>
                        <div>{{ $vehicle->parkingSlot->parking_no }} ({{ $vehicle->parkingSlot->type ?? 'Regular' }})</div>
                    </div>
                    @endif

                    @if($vehicle->sticker_number)
                    <div class="mb-3">
                        <div class="info-label">Sticker Number</div>
                        <div>{{ $vehicle->sticker_number }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-bolt"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Edit Button -->
                    @can('update', $vehicle)
                    <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="action-btn btn-edit text-decoration-none">
                        <i class="fas fa-edit"></i>
                        Edit Vehicle
                    </a>
                    @endcan

                    <!-- View Owner Button -->
                    <!-- @if($vehicle->resident_id)
                    <a href="{{ route('residents.profile', $vehicle->resident_id) }}" class="action-btn btn-view-owner text-decoration-none">
                        <i class="fas fa-user"></i>
                        View Owner Details
                    </a>
                    @endif -->

                    <!-- Delete Button (Archive) -->
                    @can('delete', $vehicle)
                    <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to archive this vehicle? It can be restored later.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-archive">
                            <i class="fas fa-archive"></i>
                            Archive Vehicle
                        </button>
                    </form>
                    @endcan

                    <!-- Print/Download Option -->
                    <button onclick="window.print()" class="action-btn" style="background: #f8f9fa; color: #212529; border: 1px solid #dee2e6;">
                        <i class="fas fa-print"></i>
                        Print Details
                    </button>
                </div>
            </div>

            <!-- Activity Log Card (Optional) -->
            @if($vehicle->created_by || $vehicle->modified_by)
            <div class="detail-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-history"></i>
                        Activity Log
                    </h5>
                </div>
                <div class="card-body">
                    @if($vehicle->created_by)
                    <div class="mb-2">
                        <small class="text-muted d-block">Created by</small>
                        <span>{{ $vehicle->creator->name ?? 'System' }} on {{ $vehicle->created_at ? $vehicle->created_at->format('d M Y H:i') : '' }}</span>
                    </div>
                    @endif

                    @if($vehicle->modified_by)
                    <div class="mb-2">
                        <small class="text-muted d-block">Last modified by</small>
                        <span>{{ $vehicle->modifier->name ?? 'System' }} on {{ $vehicle->modified_on ? date('d M Y H:i', strtotime($vehicle->modified_on)) : '' }}</span>
                    </div>
                    @endif

                    @if($vehicle->deleted_at)
                    <div class="mb-2">
                        <small class="text-muted d-block">Archived on</small>
                        <span>{{ date('d M Y H:i', strtotime($vehicle->deleted_at)) }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Print Styles -->
<style media="print">
    .back-link, .detail-card .card-header, .action-btn, footer, nav {
        display: none !important;
    }
    .container-fluid {
        padding: 0 !important;
    }
    .detail-card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
</style>

@endsection

@push('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush
