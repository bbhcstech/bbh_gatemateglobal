@extends('admin.layout.app')

@section('title', 'Archived Family Members')

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
    .stat-icon.active { background-color: #d4edda; color: #155724; }
    .stat-icon.mobile { background-color: #fff3cd; color: #856404; }
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
    .member-checkbox {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    /* Member Avatar */
    .member-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }

    .member-avatar i {
        font-size: 1.2rem;
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

    /* Relation Badge */
    .relation-badge {
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .relation-father { background-color: #dbeafe; color: #1e40af; }
    .relation-mother { background-color: #fce7f3; color: #9d174d; }
    .relation-son { background-color: #d1fae5; color: #065f46; }
    .relation-daughter { background-color: #fed7aa; color: #92400e; }
    .relation-spouse { background-color: #e2e8f0; color: #334155; }
    .relation-other { background-color: #f1f5f9; color: #475569; }

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

    /* Resident Info */
    .resident-info {
        display: flex;
        flex-direction: column;
    }

    .resident-name {
        font-weight: 600;
        color: #212529;
    }

    .resident-flat {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 2px;
    }

    /* Member Details */
    .member-name {
        font-weight: 600;
        color: #212529;
        margin-bottom: 3px;
    }

    .member-mobile {
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

    /* Mobile Badge */
    .mobile-badge {
        background-color: #f3e8ff;
        color: #6b21a8;
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
                Archived Family Members
            </h1>
            <p>Manage and restore soft-deleted family member records</p>
        </div>
        <div>
            <a href="{{ route('family-members.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Active Members
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
            <div class="stat-icon active">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h6>Previously Active</h6>
                <h3>{{ $activeArchived ?? 0 }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon mobile">
                <i class="fas fa-phone-alt"></i>
            </div>
            <div class="stat-info">
                <h6>With Mobile</h6>
                <h3>{{ $withMobileArchived ?? 0 }}</h3>
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
                Archived Family Member Records
            </h5>
            <span class="total-badge">
                <i class="fas fa-database mr-1"></i>
                Total: {{ $familyMembers->total() ?? $familyMembers->count() }}
            </span>
        </div>

        @if(!$familyMembers->isEmpty())
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
                  action="{{ route('family-members.bulk-restore') }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return validateBulkAction('restore')">
                @csrf
                <input type="hidden" name="ids" id="restoreMemberIds">
                <button type="submit" class="bulk-restore-btn" id="bulkRestoreBtn" disabled>
                    <i class="fas fa-trash-restore"></i>
                    Restore Selected
                </button>
            </form>

            @if(auth()->user()->role === 'admin')
            <form id="bulkDeleteForm"
                  action="{{ route('family-members.bulk-force-delete') }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return validateBulkAction('delete')">
                @csrf
                @method('DELETE')
                <input type="hidden" name="ids" id="deleteMemberIds">
                <button type="submit" class="bulk-delete-btn" id="bulkDeleteBtn" disabled>
                    <i class="fas fa-trash"></i>
                    Delete Permanently
                </button>
            </form>
            @endif
        </div>
        @endif

        <div class="table-responsive">
            @if($familyMembers->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-archive"></i>
                    </div>
                    <h5>No Archived Family Members Found</h5>
                    <p>There are no family members in the archive at the moment.</p>
                    <a href="{{ route('family-members.index') }}" class="btn-primary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Active Members
                    </a>
                </div>
            @else
                <table class="archive-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">
                                <input type="checkbox"
                                       class="member-checkbox"
                                       id="selectAllCheckbox"
                                       onclick="toggleSelectAll(this)">
                            </th>
                            <th>#</th>
                            <th>Member</th>
                            <th>Relation</th>
                            <th>Contact</th>
                            <th>Resident & Flat</th>
                            <th>Deleted On</th>
                            <th>Status Before</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($familyMembers as $index => $member)
                            @php
                                $relationName = $member->relation->name ?? 'Other';
                                $relationClass = match($relationName) {
                                    'Father', 'Grandfather' => 'relation-father',
                                    'Mother', 'Grandmother' => 'relation-mother',
                                    'Son', 'Brother' => 'relation-son',
                                    'Daughter', 'Sister' => 'relation-daughter',
                                    'Spouse' => 'relation-spouse',
                                    default => 'relation-other'
                                };
                                $relationIcon = match(true) {
                                    in_array($relationName, ['Father', 'Son', 'Brother', 'Grandfather']) => 'fa-male',
                                    in_array($relationName, ['Mother', 'Daughter', 'Sister', 'Grandmother']) => 'fa-female',
                                    $relationName == 'Spouse' => 'fa-heart',
                                    default => 'fa-user'
                                };
                            @endphp
                            <tr id="member-row-{{ $member->member_id }}">
                                <td>
                                    <input type="checkbox"
                                           class="member-checkbox member-checkbox-item"
                                           value="{{ $member->member_id }}"
                                           onchange="updateSelectedCount()">
                                </td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="member-avatar mr-2">
                                            <i class="fas {{ $relationIcon }}"></i>
                                        </div>
                                        <div>
                                            <div class="member-name">{{ $member->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="relation-badge {{ $relationClass }}">
                                        <i class="fas {{ $relationIcon }}"></i>
                                        {{ $relationName }}
                                    </span>
                                </td>
                                <td>
                                    @if($member->mobile)
                                        <span class="mobile-badge">
                                            <i class="fas fa-phone-alt"></i>
                                            {{ $member->mobile }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="resident-info">
                                        <span class="resident-name">{{ $member->resident->name ?? 'N/A' }}</span>
                                        @if($member->resident)
                                            <span class="resident-flat">
                                                Flat: {{ $member->resident->flat_no ?? 'N/A' }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="deleted-badge">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $member->deleted_at ? $member->deleted_at->format('d M Y H:i') : 'Unknown' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $member->activity_status ? 'status-active' : 'status-inactive' }}">
                                        <i class="fas fa-{{ $member->activity_status ? 'check-circle' : 'times-circle' }}"></i>
                                        {{ $member->activity_status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <!-- View Details -->
                                        <a href="{{ route('family-members.archived-show', $member->member_id) }}"
                                           class="action-btn btn-view"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Restore -->
                                        <form action="{{ route('family-members.restore', $member->member_id) }}"
                                              method="POST"
                                              class="d-inline restore-form"
                                              onsubmit="return confirm('Restore this family member? It will be moved back to active members.')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="action-btn btn-restore" title="Restore">
                                                <i class="fas fa-trash-restore"></i>
                                            </button>
                                        </form>

                                        <!-- Permanent Delete (Admin Only) -->
                                        @if(auth()->user()->role === 'admin')
                                            <form action="{{ route('family-members.force-delete', $member->member_id) }}"
                                                  method="POST"
                                                  class="d-inline force-delete-form"
                                                  onsubmit="return confirm('WARNING: This will permanently delete this family member! This action cannot be undone.')">
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
                @if(method_exists($familyMembers, 'links'))
                <div class="d-flex justify-content-between align-items-center mt-3 pb-3">
                    <div class="pagination-info">
                        Showing {{ $familyMembers->firstItem() ?? 0 }} to {{ $familyMembers->lastItem() ?? 0 }} of {{ $familyMembers->total() }} entries
                    </div>
                    <div class="pagination">
                        {{ $familyMembers->links() }}
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let imageModal;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize image modal if it exists (for future use)
        const modalElement = document.getElementById('imageModal');
        if (modalElement) {
            imageModal = new bootstrap.Modal(modalElement);
        }
        updateSelectedCount();
    });

    function previewImage(src) {
        document.getElementById('modalImage').src = src;
        if (imageModal) {
            imageModal.show();
        }
    }

    // Toggle select all checkboxes
    function toggleSelectAll(source) {
        const checkboxes = document.getElementsByClassName('member-checkbox-item');
        for(let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
        updateSelectedCount();
    }

    // Update selected count and bulk action buttons
    function updateSelectedCount() {
        const checkboxes = document.getElementsByClassName('member-checkbox-item');
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

        if (selectedCount) {
            selectedCount.textContent = count + ' selected';
        }

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
        const checkboxes = document.getElementsByClassName('member-checkbox-item');
        const selectedIds = [];

        for(let i = 0; i < checkboxes.length; i++) {
            if(checkboxes[i].checked) {
                selectedIds.push(checkboxes[i].value);
            }
        }

        if(selectedIds.length === 0) {
            alert('Please select at least one family member.');
            return false;
        }

        let message = '';
        if(action === 'restore') {
            message = `Are you sure you want to restore ${selectedIds.length} family member(s)? They will be moved back to active members.`;
            document.getElementById('restoreMemberIds').value = selectedIds.join(',');
        } else {
            message = `WARNING: Are you sure you want to permanently delete ${selectedIds.length} family member(s)? This action cannot be undone.`;
            document.getElementById('deleteMemberIds').value = selectedIds.join(',');
        }

        return confirm(message);
    }
</script>
@endpush

@push('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush
