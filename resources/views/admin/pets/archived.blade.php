@extends('admin.layout.app')

@section('title', 'Archived Pets')

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
    .stat-icon.vaccinated { background-color: #d4edda; color: #155724; }
    .stat-icon.dangerous { background-color: #f8d7da; color: #721c24; }
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
    .pet-checkbox {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    /* Pet Image Thumb */
    .pet-thumb {
        width: 40px;
        height: 40px;
        border-radius: 3px;
        object-fit: cover;
        border: 1px solid #dee2e6;
        cursor: pointer;
    }

    .pet-thumb-placeholder {
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

    /* Status Badges */
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

    /* Vaccination Badge */
    .vaccination-badge {
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .vaccination-badge.vaccinated { background-color: #d4edda; color: #155724; }
    .vaccination-badge.expiring { background-color: #fff3cd; color: #856404; }
    .vaccination-badge.expired { background-color: #f8d7da; color: #721c24; }

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

    /* Pet Details */
    .pet-name {
        font-weight: 600;
        color: #212529;
        margin-bottom: 3px;
    }

    .pet-meta {
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

    /* Dangerous Badge */
    .dangerous-badge {
        background-color: #f8d7da;
        color: #721c24;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 0.7rem;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        margin-left: 5px;
    }
</style>

<div class="container-fluid py-3">
    <!-- Archive Header -->
    <div class="archive-header d-flex justify-content-between align-items-center">
        <div>
            <h1>
                <i class="fas fa-archive mr-2"></i>
                Archived Pets
            </h1>
            <p>Manage and restore soft-deleted pet records</p>
        </div>
        <div>
            <a href="{{ route('pets.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Active Pets
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
            <div class="stat-icon vaccinated">
                <i class="fas fa-syringe"></i>
            </div>
            <div class="stat-info">
                <h6>Vaccinated</h6>
                <h3>{{ $vaccinatedArchived ?? 0 }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon dangerous">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h6>Dangerous</h6>
                <h3>{{ $dangerousArchived ?? 0 }}</h3>
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
                Archived Pet Records
            </h5>
            <span class="total-badge">
                <i class="fas fa-database mr-1"></i>
                Total: {{ $pets->total() ?? $pets->count() }}
            </span>
        </div>

        @if(!$pets->isEmpty())
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
                  action="{{ route('pets.bulk-restore') }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return validateBulkAction('restore')">
                @csrf
                <input type="hidden" name="ids" id="restorePetIds">
                <button type="submit" class="bulk-restore-btn" id="bulkRestoreBtn" disabled>
                    <i class="fas fa-trash-restore"></i>
                    Restore Selected
                </button>
            </form>

            @if(auth()->user()->role === 'admin')
            <form id="bulkDeleteForm"
                  action="{{ route('pets.bulk-force-delete') }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return validateBulkAction('delete')">
                @csrf
                @method('DELETE')
                <input type="hidden" name="ids" id="deletePetIds">
                <button type="submit" class="bulk-delete-btn" id="bulkDeleteBtn" disabled>
                    <i class="fas fa-trash"></i>
                    Delete Permanently
                </button>
            </form>
            @endif
        </div>
        @endif

        <div class="table-responsive">
            @if($pets->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-archive"></i>
                    </div>
                    <h5>No Archived Pets Found</h5>
                    <p>There are no pets in the archive at the moment.</p>
                    <a href="{{ route('pets.index') }}" class="btn-primary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Active Pets
                    </a>
                </div>
            @else
                <table class="archive-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">
                                <input type="checkbox"
                                       class="pet-checkbox"
                                       id="selectAllCheckbox"
                                       onclick="toggleSelectAll(this)">
                            </th>
                            <th>#</th>
                            <th>Image</th>
                            <th>Pet Details</th>
                            <th>Owner & Flat</th>
                            <th>Deleted On</th>
                            <th>Vaccination</th>
                            <th>Status Before</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pets as $index => $pet)
                            <tr id="pet-row-{{ $pet->id }}">
                                <td>
                                    <input type="checkbox"
                                           class="pet-checkbox pet-checkbox-item"
                                           value="{{ $pet->id }}"
                                           onchange="updateSelectedCount()">
                                </td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($pet->image && file_exists(public_path($pet->image)))
                                        <img src="{{ asset($pet->image) }}"
                                             class="pet-thumb"
                                             alt="Pet"
                                             onclick="previewImage('{{ asset($pet->image) }}')"
                                             style="cursor: pointer;">
                                    @else
                                        <div class="pet-thumb-placeholder">
                                            <i class="fas fa-paw"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="pet-name">
                                        {{ $pet->pet_name }}
                                        @if($pet->is_dangerous)
                                            <span class="dangerous-badge">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                Dangerous
                                            </span>
                                        @endif
                                    </div>
                                    <div class="pet-meta">
                                        {{ $pet->pet_type ?? 'N/A' }}
                                        @if($pet->pet_breed)
                                            • {{ $pet->pet_breed }}
                                        @endif
                                        @if($pet->pet_age)
                                            • {{ $pet->pet_age }} yrs
                                        @endif
                                        @if($pet->pet_gender)
                                            • <i class="fas fa-{{ $pet->pet_gender == 'male' ? 'mars' : 'venus' }}"></i>
                                            {{ ucfirst($pet->pet_gender) }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="owner-info">
                                        <span class="owner-name">{{ $pet->resident->name ?? 'N/A' }}</span>
                                        @if($pet->flat)
                                            <span class="owner-flat">
                                                Flat: {{ $pet->flat->flat_no ?? 'N/A' }}
                                            </span>
                                        @endif
                                        @if($pet->collar_microchip_no)
                                            <span class="owner-flat">
                                                <i class="fas fa-microchip"></i>
                                                {{ $pet->collar_microchip_no }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="deleted-badge">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $pet->deleted_at ? $pet->deleted_at->format('d M Y H:i') : 'Unknown' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $vaccinationClass = $pet->getVaccinationStatusClass();
                                        $vaccinationText = $pet->getVaccinationStatusText();
                                    @endphp
                                    <span class="vaccination-badge {{ $vaccinationClass }}">
                                        <i class="fas fa-{{ $vaccinationClass == 'vaccinated' ? 'check-circle' : ($vaccinationClass == 'expiring' ? 'exclamation-triangle' : 'times-circle') }}"></i>
                                        {{ $vaccinationText }}
                                    </span>
                                    @if($pet->vaccination_expiry_date && $pet->vaccination_status == 'yes')
                                        <div style="font-size: 0.7rem; color: #6c757d; margin-top: 2px;">
                                            Exp: {{ $pet->vaccination_expiry_date->format('d M Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge {{ $pet->activity_status ? 'status-active' : 'status-inactive' }}">
                                        <i class="fas fa-{{ $pet->activity_status ? 'check-circle' : 'times-circle' }}"></i>
                                        {{ $pet->activity_status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <!-- View Details -->
                                        <a href="{{ route('pets.archived-show', $pet->id) }}"
                                           class="action-btn btn-view"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Restore -->
                                        <form action="{{ route('pets.restore', $pet->id) }}"
                                              method="POST"
                                              class="d-inline restore-form"
                                              onsubmit="return confirm('Restore this pet? It will be moved back to active pets.')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="action-btn btn-restore" title="Restore">
                                                <i class="fas fa-trash-restore"></i>
                                            </button>
                                        </form>

                                        <!-- Permanent Delete (Admin Only) -->
                                        @if(auth()->user()->role === 'admin')
                                            <form action="{{ route('pets.force-delete', $pet->id) }}"
                                                  method="POST"
                                                  class="d-inline force-delete-form"
                                                  onsubmit="return confirm('WARNING: This will permanently delete this pet! This action cannot be undone.')">
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
                @if(method_exists($pets, 'links'))
                <div class="d-flex justify-content-between align-items-center mt-3 pb-3">
                    <div class="pagination-info">
                        Showing {{ $pets->firstItem() ?? 0 }} to {{ $pets->lastItem() ?? 0 }} of {{ $pets->total() }} entries
                    </div>
                    <div class="pagination">
                        {{ $pets->links() }}
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
                    Pet Image
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
        const checkboxes = document.getElementsByClassName('pet-checkbox-item');
        for(let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
        updateSelectedCount();
    }

    // Update selected count and bulk action buttons
    function updateSelectedCount() {
        const checkboxes = document.getElementsByClassName('pet-checkbox-item');
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
        const checkboxes = document.getElementsByClassName('pet-checkbox-item');
        const selectedIds = [];

        for(let i = 0; i < checkboxes.length; i++) {
            if(checkboxes[i].checked) {
                selectedIds.push(checkboxes[i].value);
            }
        }

        if(selectedIds.length === 0) {
            alert('Please select at least one pet.');
            return false;
        }

        let message = '';
        if(action === 'restore') {
            message = `Are you sure you want to restore ${selectedIds.length} pet(s)? They will be moved back to active pets.`;
            document.getElementById('restorePetIds').value = selectedIds.join(',');
        } else {
            message = `WARNING: Are you sure you want to permanently delete ${selectedIds.length} pet(s)? This action cannot be undone.`;
            document.getElementById('deletePetIds').value = selectedIds.join(',');
        }

        return confirm(message);
    }
</script>
@endpush

@push('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush
