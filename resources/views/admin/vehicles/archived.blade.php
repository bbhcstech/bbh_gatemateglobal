@extends('admin.layout.app')

@section('title', 'Archived Vehicles')

@section('content')
<style>
    /* Standard Admin Theme */
    .archive-header {
        background-color: #343a40;
        padding: 20px 25px;
        border-radius: 5px;
        margin-bottom: 25px;
        color: white;
    }

    .archive-header h1 {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .archive-header p {
        font-size: 0.95rem;
        opacity: 0.9;
        margin: 0;
    }

    .back-button {
        background-color: rgba(255,255,255,0.2);
        padding: 8px 15px;
        border-radius: 4px;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .back-button:hover {
        background-color: rgba(255,255,255,0.3);
        color: white;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .stat-card {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-icon.total { background-color: #e9ecef; color: #495057; }
    .stat-icon.bike { background-color: #e9ecef; color: #495057; }
    .stat-icon.car { background-color: #e9ecef; color: #495057; }
    .stat-icon.month { background-color: #e9ecef; color: #495057; }

    .stat-info h6 {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 5px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .stat-info h3 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #212529;
        margin: 0;
    }

    /* Table Card */
    .table-card {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        overflow: hidden;
    }

    .card-header {
        background-color: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .card-header h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #495057;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .total-badge {
        background-color: #6c757d;
        color: white;
        padding: 4px 10px;
        border-radius: 3px;
        font-size: 0.8rem;
    }

    /* Bulk Actions */
    .bulk-actions {
        display: flex;
        gap: 15px;
        align-items: center;
        background-color: #f8f9fa;
        padding: 10px 20px;
        border-bottom: 1px solid #dee2e6;
    }

    .selected-count {
        background-color: #007bff;
        color: white;
        padding: 3px 10px;
        border-radius: 3px;
        font-size: 0.85rem;
    }

    .bulk-restore-btn {
        background-color: #28a745;
        border: none;
        padding: 6px 15px;
        border-radius: 3px;
        color: white;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
    }

    .bulk-restore-btn:hover:not(:disabled) {
        background-color: #218838;
    }

    .bulk-restore-btn:disabled {
        background-color: #6c757d;
        cursor: not-allowed;
        opacity: 0.65;
    }

    .bulk-delete-btn {
        background-color: #dc3545;
        border: none;
        padding: 6px 15px;
        border-radius: 3px;
        color: white;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
    }

    .bulk-delete-btn:hover:not(:disabled) {
        background-color: #c82333;
    }

    .bulk-delete-btn:disabled {
        background-color: #6c757d;
        cursor: not-allowed;
        opacity: 0.65;
    }

    .select-all-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .select-all-checkbox {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .select-all-label {
        font-size: 0.9rem;
        color: #495057;
        cursor: pointer;
        margin: 0;
    }

    /* Table Styles */
    .table-responsive {
        padding: 0 20px 20px 20px;
    }

    .archive-table {
        width: 100%;
        border-collapse: collapse;
    }

    .archive-table thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 12px 10px;
        border-bottom: 2px solid #dee2e6;
    }

    .archive-table tbody td {
        padding: 15px 10px;
        color: #212529;
        font-size: 0.95rem;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .archive-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Checkbox Styles */
    .vehicle-checkbox {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    /* Vehicle Image Thumb */
    .vehicle-thumb {
        width: 40px;
        height: 40px;
        border-radius: 3px;
        object-fit: cover;
        border: 1px solid #dee2e6;
        cursor: pointer;
    }

    .vehicle-thumb-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 3px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        border: 1px solid #dee2e6;
    }

    /* Deleted Badge */
    .deleted-badge {
        background-color: #f8d7da;
        color: #721c24;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Action Buttons */
    .action-group {
        display: flex;
        gap: 5px;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 3px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        background-color: white;
        color: #495057;
        text-decoration: none;
        font-size: 0.85rem;
        cursor: pointer;
    }

    .action-btn:hover {
        background-color: #e9ecef;
    }

    .btn-view {
        color: #007bff;
        border-color: #007bff;
    }

    .btn-view:hover {
        background-color: #007bff;
        color: white;
    }

    .btn-restore {
        color: #28a745;
        border-color: #28a745;
    }

    .btn-restore:hover {
        background-color: #28a745;
        color: white;
    }

    .btn-delete {
        color: #dc3545;
        border-color: #dc3545;
    }

    .btn-delete:hover {
        background-color: #dc3545;
        color: white;
    }

    /* Status Badge */
    .status-badge {
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .status-active { background-color: #d4edda; color: #155724; }
    .status-inactive { background-color: #f8d7da; color: #721c24; }
    .status-pending { background-color: #fff3cd; color: #856404; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }

    .empty-icon {
        font-size: 4rem;
        color: #adb5bd;
        margin-bottom: 15px;
    }

    .empty-state h5 {
        font-size: 1.2rem;
        color: #495057;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #6c757d;
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 8px 20px;
        border-radius: 3px;
        color: white;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary:hover {
        background-color: #0069d9;
    }

    /* Pagination */
    .pagination {
        display: flex;
        gap: 3px;
    }

    .pagination .page-link {
        border: 1px solid #dee2e6;
        border-radius: 3px;
        color: #007bff;
        padding: 6px 12px;
        text-decoration: none;
    }

    .pagination .page-link:hover {
        background-color: #e9ecef;
    }

    .pagination-info {
        color: #6c757d;
        font-size: 0.9rem;
    }

    /* Owner Info */
    .owner-info {
        display: flex;
        flex-direction: column;
    }

    .owner-name {
        font-weight: 600;
        color: #212529;
    }

    .owner-flat {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 2px;
    }

    /* Vehicle Details */
    .vehicle-number {
        font-weight: 600;
        color: #212529;
        margin-bottom: 3px;
    }

    .vehicle-meta {
        font-size: 0.8rem;
        color: #6c757d;
    }

    /* Alert Messages */
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 3px;
        padding: 12px 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 3px;
        padding: 12px 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
</style>

<div class="container-fluid py-3">
    <!-- Archive Header -->
    <div class="archive-header d-flex justify-content-between align-items-center">
        <div>
            <h1>
                <i class="fas fa-archive mr-2"></i>
                Archived Vehicles
            </h1>
            <p>Manage and restore soft-deleted vehicle records</p>
        </div>
        <div>
            <a href="{{ route('vehicles.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Active Vehicles
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-archive"></i>
            </div>
            <div class="stat-info">
                <h6>Total Archived</h6>
                <h3>{{ $totalArchived ?? 0 }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bike">
                <i class="fas fa-motorcycle"></i>
            </div>
            <div class="stat-info">
                <h6>2-Wheelers</h6>
                <h3>{{ $twoWheelers ?? 0 }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon car">
                <i class="fas fa-car"></i>
            </div>
            <div class="stat-info">
                <h6>4-Wheelers</h6>
                <h3>{{ $fourWheelers ?? 0 }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon month">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-info">
                <h6>This Month</h6>
                <h3>{{ $monthlyArchived ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="table-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-history"></i>
                Archived Vehicle Records
            </h5>
            <span class="total-badge">
                <i class="fas fa-database mr-1"></i>
                Total: {{ $vehicles->total() ?? $vehicles->count() }}
            </span>
        </div>

        @if(!$vehicles->isEmpty())
        <!-- Bulk Actions -->
        <div class="bulk-actions">
            <div class="select-all-wrapper">
                <input type="checkbox"
                       class="select-all-checkbox"
                       id="selectAll"
                       onclick="toggleSelectAll(this)">
                <label for="selectAll" class="select-all-label">Select All</label>
            </div>

            <span class="selected-count" id="selectedCount">0 selected</span>

            <form id="bulkRestoreForm"
                  action="{{ route('vehicles.bulk-restore') }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return validateBulkAction('restore')">
                @csrf
                @method('PUT')
                <input type="hidden" name="vehicle_ids" id="restoreVehicleIds">
                <button type="submit" class="bulk-restore-btn" id="bulkRestoreBtn" disabled>
                    <i class="fas fa-trash-restore"></i>
                    Restore Selected
                </button>
            </form>

            @if(auth()->user()->role === 'admin')
            <form id="bulkDeleteForm"
                  action="{{ route('vehicles.bulk-force-delete') }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return validateBulkAction('delete')">
                @csrf
                @method('DELETE')
                <input type="hidden" name="vehicle_ids" id="deleteVehicleIds">
                <button type="submit" class="bulk-delete-btn" id="bulkDeleteBtn" disabled>
                    <i class="fas fa-trash"></i>
                    Delete Permanently
                </button>
            </form>
            @endif
        </div>
        @endif

        <div class="table-responsive">
            @if($vehicles->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-archive"></i>
                    </div>
                    <h5>No Archived Vehicles Found</h5>
                    <p>There are no vehicles in the archive at the moment.</p>
                    <a href="{{ route('vehicles.index') }}" class="btn-primary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Active Vehicles
                    </a>
                </div>
            @else
                <table class="archive-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">
                                <input type="checkbox"
                                       class="vehicle-checkbox"
                                       id="selectAllCheckbox"
                                       onclick="toggleSelectAll(this)">
                            </th>
                            <th>#</th>
                            <th>Image</th>
                            <th>Vehicle Details</th>
                            <th>Owner</th>
                            <th>Deleted On</th>
                            <th>Status Before</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $index => $vehicle)
                            <tr id="vehicle-row-{{ $vehicle->id }}">
                                <td>
                                    <input type="checkbox"
                                           class="vehicle-checkbox vehicle-checkbox-item"
                                           value="{{ $vehicle->id }}"
                                           onchange="updateSelectedCount()">
                                </td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($vehicle->vehicle_image && file_exists(public_path($vehicle->vehicle_image)))
                                        <img src="{{ asset($vehicle->vehicle_image) }}"
                                             class="vehicle-thumb"
                                             alt="Vehicle"
                                             onclick="previewImage('{{ asset($vehicle->vehicle_image) }}')"
                                             style="cursor: pointer;">
                                    @else
                                        <div class="vehicle-thumb-placeholder">
                                            <i class="fas fa-car"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="vehicle-number">{{ $vehicle->vehicle_number }}</div>
                                    <div class="vehicle-meta">
                                        {{ $vehicle->vehicle_type ?? 'N/A' }}
                                        @if($vehicle->make || $vehicle->model)
                                            <br>{{ $vehicle->make ?? '' }} {{ $vehicle->model ?? '' }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="owner-info">
                                        <span class="owner-name">{{ $vehicle->resident->name ?? 'N/A' }}</span>
                                        @if($vehicle->resident && $vehicle->resident->flat)
                                            <span class="owner-flat">
                                                Flat: {{ $vehicle->resident->flat->flat_no ?? 'N/A' }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="deleted-badge">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $vehicle->deleted_at ? $vehicle->deleted_at->format('d M Y H:i') : 'Unknown' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $status = $vehicle->status ?? 'pending';
                                        $statusClass = match($status) {
                                            'active', 'approved' => 'status-active',
                                            'inactive', 'rejected' => 'status-inactive',
                                            default => 'status-pending'
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <!-- View Details -->
                                        <a href="{{ route('archived.show', $vehicle->id) }}"
                                           class="action-btn btn-view"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Restore -->
                                        <form action="{{ route('vehicles.restore', $vehicle->id) }}"
                                              method="POST"
                                              class="d-inline restore-form"
                                              onsubmit="return confirm('Restore this vehicle? It will be moved back to active vehicles.')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="action-btn btn-restore" title="Restore">
                                                <i class="fas fa-trash-restore"></i>
                                            </button>
                                        </form>

                                        <!-- Permanent Delete (Admin Only) -->
                                        @if(auth()->user()->role === 'admin')
                                            <form action="{{ route('vehicles.force-delete', $vehicle->id) }}"
                                                  method="POST"
                                                  class="d-inline force-delete-form"
                                                  onsubmit="return confirm('WARNING: This will permanently delete this vehicle! This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn btn-delete" title="Delete Permanently">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                @if(method_exists($vehicles, 'links'))
                <div class="d-flex justify-content-between align-items-center mt-3 pb-3">
                    <div class="pagination-info">
                        Showing {{ $vehicles->firstItem() ?? 0 }} to {{ $vehicles->lastItem() ?? 0 }} of {{ $vehicles->total() }} entries
                    </div>
                    <div class="pagination">
                        {{ $vehicles->links() }}
                    </div>
                </div>
                @endif
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
                    <i class="fas fa-image mr-1"></i>
                    Vehicle Image
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-3">
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
        updateSelectedCount();
    });

    function previewImage(src) {
        document.getElementById('modalImage').src = src;
        imageModal.show();
    }

    // Toggle select all checkboxes
    function toggleSelectAll(source) {
        const checkboxes = document.getElementsByClassName('vehicle-checkbox-item');
        for(let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
        updateSelectedCount();
    }

    // Update selected count and bulk action buttons
    function updateSelectedCount() {
        const checkboxes = document.getElementsByClassName('vehicle-checkbox-item');
        const selectedCount = document.getElementById('selectedCount');
        const bulkRestoreBtn = document.getElementById('bulkRestoreBtn');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');

        let count = 0;
        for(let i = 0; i < checkboxes.length; i++) {
            if(checkboxes[i].checked) {
                count++;
            }
        }

        selectedCount.textContent = count + ' selected';

        // Enable/disable bulk buttons
        if(bulkRestoreBtn) {
            bulkRestoreBtn.disabled = count === 0;
        }
        if(bulkDeleteBtn) {
            bulkDeleteBtn.disabled = count === 0;
        }

        // Update select all checkbox
        if(selectAllCheckbox) {
            selectAllCheckbox.checked = count === checkboxes.length && checkboxes.length > 0;
        }
    }

    // Validate bulk action
    function validateBulkAction(action) {
        const checkboxes = document.getElementsByClassName('vehicle-checkbox-item');
        const selectedIds = [];

        for(let i = 0; i < checkboxes.length; i++) {
            if(checkboxes[i].checked) {
                selectedIds.push(checkboxes[i].value);
            }
        }

        if(selectedIds.length === 0) {
            alert('Please select at least one vehicle.');
            return false;
        }

        let message = '';
        if(action === 'restore') {
            message = `Are you sure you want to restore ${selectedIds.length} vehicle(s)? They will be moved back to active vehicles.`;
            document.getElementById('restoreVehicleIds').value = JSON.stringify(selectedIds);
        } else {
            message = `WARNING: Are you sure you want to permanently delete ${selectedIds.length} vehicle(s)? This action cannot be undone.`;
            document.getElementById('deleteVehicleIds').value = JSON.stringify(selectedIds);
        }

        return confirm(message);
    }
</script>
@endpush

@push('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush
