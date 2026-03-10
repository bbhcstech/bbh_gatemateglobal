@extends('admin.layout.app')

@section('title', 'Family Members Management')

@section('content')
<style>
    /* Clean & Professional Theme */
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --primary-light: #dbeafe;
        --secondary: #64748b;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #1e293b;
        --light: #f8fafc;
        --border: #e2e8f0;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container-fluid {
        background: #f1f4f9;
        min-height: 100vh;
        padding: 1.5rem !important;
    }

    /* Header */
    .page-header {
        background: white;
        border-radius: 16px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-title h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .header-title p {
        color: var(--secondary);
        font-size: 0.875rem;
        margin: 0;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.25rem;
        border: 1px solid var(--border);
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        border-color: var(--primary);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .stat-icon.total { background: var(--primary-light); color: var(--primary); }
    .stat-icon.active { background: #d1fae5; color: var(--success); }
    .stat-icon.relations { background: #fed7aa; color: var(--warning); }
    .stat-icon.families { background: #e2e8f0; color: var(--secondary); }

    .stat-info h6 {
        font-size: 0.75rem;
        color: var(--secondary);
        margin-bottom: 0.25rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .stat-info h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
        line-height: 1.2;
    }

    /* Main Card */
    .main-card {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--border);
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .card-header {
        background: white;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .card-header h5 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-header h5 i {
        color: var(--primary);
    }

    /* Toolbar */
    .toolbar {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .btn-outline {
        background: white;
        border-color: var(--border);
        color: var(--secondary);
    }

    .btn-outline:hover {
        background: var(--light);
        border-color: var(--primary);
        color: var(--primary);
    }

    .btn-info {
        background: #0891b2;
        color: white;
    }

    .btn-info:hover {
        background: #0e7490;
    }

    .btn-danger {
        background: white;
        border-color: var(--border);
        color: var(--danger);
    }

    .btn-danger:hover {
        background: #fee2e2;
        border-color: var(--danger);
    }

    .btn-success {
        background: white;
        border-color: var(--border);
        color: var(--success);
    }

    .btn-success:hover {
        background: #d1fae5;
        border-color: var(--success);
    }

    .btn.active {
        background: var(--primary-light);
        border-color: var(--primary);
        color: var(--primary);
    }

    /* Table */
    .table-responsive {
        padding: 1.5rem;
        overflow-x: auto;
    }

    .family-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.5rem;
        min-width: 1200px;
    }

    .family-table thead th {
        background: #f8fafc;
        color: var(--secondary);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .family-table tbody tr {
        background: white;
        border-radius: 12px;
        transition: all 0.2s;
    }

    .family-table tbody tr:hover {
        background: #f8fafc;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .family-table tbody td {
        padding: 1rem;
        color: var(--dark);
        font-size: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    /* Checkbox */
    .checkbox-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .checkbox-custom {
        width: 18px;
        height: 18px;
        border: 2px solid var(--border);
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .checkbox-custom.checked {
        background: var(--primary);
        border-color: var(--primary);
    }

    .checkbox-custom.checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 12px;
    }

    /* Member Avatar */
    .member-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.2rem;
        border: 2px solid var(--border);
        transition: all 0.2s;
    }

    .member-avatar:hover {
        border-color: var(--primary);
        transform: scale(1.1);
    }

    /* Relation Badge */
    .relation-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        white-space: nowrap;
    }

    .relation-badge.father {
        background: #dbeafe;
        color: #1e40af;
    }

    .relation-badge.mother {
        background: #fce7f3;
        color: #9d174d;
    }

    .relation-badge.son {
        background: #d1fae5;
        color: #065f46;
    }

    .relation-badge.daughter {
        background: #fed7aa;
        color: #92400e;
    }

    .relation-badge.spouse {
        background: #e2e8f0;
        color: #334155;
    }

    .relation-badge.other {
        background: #f1f5f9;
        color: #475569;
    }

    /* Action Buttons */
    .action-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        border: 1px solid var(--border);
        background: white;
        color: var(--secondary);
        cursor: pointer;
        text-decoration: none;
    }

    .action-btn:hover {
        background: var(--light);
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-1px);
    }

    .action-btn.view:hover { border-color: var(--primary); color: var(--primary); }
    .action-btn.edit:hover { border-color: var(--warning); color: var(--warning); }
    .action-btn.delete:hover { border-color: var(--danger); color: var(--danger); }
    .action-btn.restore:hover { border-color: var(--success); color: var(--success); }
    .action-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Resident Badge */
    .resident-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        background: var(--light);
        border-radius: 6px;
        font-size: 0.7rem;
        color: var(--secondary);
        margin-top: 0.25rem;
    }

    .resident-badge i {
        color: var(--primary);
    }

    /* Own Family Highlight */
    .own-family-row {
        background-color: rgba(16, 185, 129, 0.05) !important;
        border-left: 3px solid var(--success);
    }

    .own-family-badge {
        background: var(--success);
        color: white;
        font-size: 0.7rem;
        padding: 0.15rem 0.5rem;
        border-radius: 12px;
        margin-left: 0.5rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
    }

    .empty-icon {
        font-size: 3rem;
        color: var(--border);
        margin-bottom: 1rem;
    }

    .empty-state h6 {
        color: var(--secondary);
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
        border-bottom: 1px solid var(--border);
        padding: 1.25rem;
    }

    .modal-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark);
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid var(--border);
        padding: 1rem 1.5rem;
    }

    /* DataTables Customization */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .dataTables_paginate .paginate_button {
        border-radius: 6px !important;
        margin: 0 2px;
        padding: 0.375rem 0.75rem !important;
        border: 1px solid var(--border) !important;
        background: white !important;
        color: var(--secondary) !important;
    }

    .dataTables_paginate .paginate_button.current {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: white !important;
    }

    .dataTables_paginate .paginate_button:hover {
        background: var(--light) !important;
        border-color: var(--primary) !important;
    }

    /* Notification */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        border-left: 4px solid;
        z-index: 9999;
        animation: slideIn 0.3s ease;
    }

    .notification.success { border-left-color: var(--success); }
    .notification.error { border-left-color: var(--danger); }
    .notification.warning { border-left-color: var(--warning); }

    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    /* Filter Section */
    .filter-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid var(--border);
    }

    .filter-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
    }

    .resident-select {
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 0.5rem;
        width: 100%;
        font-size: 0.875rem;
    }

    .resident-select:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    /* Warning Text */
    .warning-text {
        color: var(--warning);
        font-size: 0.7rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Deleted Row */
    .deleted-row {
        background-color: rgba(239, 68, 68, 0.05) !important;
        opacity: 0.8;
    }

    .archived-badge {
        background: var(--secondary);
        color: white;
        font-size: 0.7rem;
        padding: 0.15rem 0.5rem;
        border-radius: 12px;
        margin-left: 0.5rem;
    }
</style>

@php
// Get logged in resident
$loggedInUserId = auth()->id();
$loggedInResident = App\Models\Resident::where('user_id', $loggedInUserId)->first();
$loggedInResidentId = $loggedInResident ? $loggedInResident->id : null;
$userRole = strtolower(optional(auth()->user()->roleMaster)->role_name ?? '');
@endphp

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="header-title">
            <h2>
                <i class="fas fa-users me-2" style="color: var(--primary);"></i>
                Family Members Management
            </h2>
            <p>Manage all residents' family members and relationships</p>
        </div>
        <div class="toolbar">
            <!-- View All Residents' Families Button (Only for Residents) -->
            @if($userRole === 'resident')
                <a href="{{ route('family-members.all-residents') }}" class="btn btn-info">
                    <i class="fas fa-users me-2"></i>
                    View All Families
                </a>
            @endif

            <!-- Archive Button -->
            @if(request()->routeIs('family-members.archived'))
                <a href="{{ route('family-members.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Active
                </a>
            @else
                <a href="{{ route('family-members.archived') }}" class="btn btn-outline">
                    <i class="fas fa-archive me-2"></i>
                    View Archive
                </a>
            @endif

            <!-- Add Family Member Button -->
            @if(in_array($userRole, ['admin', 'resident']))
                <a href="{{ route('family-members.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Add Family Member
                </a>
            @endif
        </div>
    </div>

    <!-- Stats -->
    @php
        $totalMembers = App\Models\FamilyMember::count();
        $totalResidents = App\Models\Resident::count();
        $totalRelations = App\Models\Relation::count();
        $avgPerFamily = $totalResidents > 0 ? round($totalMembers / $totalResidents, 1) : 0;
        $activeMembers = App\Models\FamilyMember::whereNull('deleted_at')->count();
        $archivedCount = App\Models\FamilyMember::onlyTrashed()->count();
    @endphp
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h6>Total Members</h6>
                <h3 id="totalMembers">{{ $totalMembers }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon active">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h6>Active</h6>
                <h3 id="activeCount">{{ $activeMembers }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon relations">
                <i class="fas fa-archive"></i>
            </div>
            <div class="stat-info">
                <h6>Archived</h6>
                <h3 id="archivedCount">{{ $archivedCount }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon families">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h6>Avg per Family</h6>
                <h3 id="avgPerFamily">{{ $avgPerFamily }}</h3>
            </div>
        </div>
    </div>

    <!-- Filter Section (only for active view) -->
    @if(!request()->routeIs('family-members.archived'))
    <div class="filter-section">
        <div class="row align-items-end">
            <div class="col-md-4">
                <div class="filter-label">Filter by Resident</div>
                <select class="resident-select" id="residentFilter" onchange="filterByResident(this.value)">
                    <option value="">All Residents</option>
                    @foreach($residents ?? [] as $resident)
                        <option value="{{ $resident->id }}" {{ request('resident_id') == $resident->id ? 'selected' : '' }}>
                            {{ $resident->name }} - Flat {{ $resident->flat_no ?? 'N/A' }}
                            @if($loggedInResidentId == $resident->id)
                                (Your Family)
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <div class="filter-label">Search</div>
                <input type="text" class="form-control" id="searchInput" placeholder="Search by name, relation, mobile..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary w-100" onclick="applyFilters()">
                    <i class="fas fa-filter me-2"></i>
                    Apply Filters
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-{{ request()->routeIs('family-members.archived') ? 'archive' : 'list' }}"></i>
                {{ request()->routeIs('family-members.archived') ? 'Archived Family Members' : 'Family Members Directory' }}
            </h5>
            <div class="toolbar">
                <!-- Export Buttons -->
                <button class="btn btn-outline" onclick="exportTable('excel')">
                    <i class="fas fa-file-excel" style="color: #10b981;"></i>
                    Excel
                </button>
                <button class="btn btn-outline" onclick="exportTable('pdf')">
                    <i class="fas fa-file-pdf" style="color: #ef4444;"></i>
                    PDF
                </button>
                <!-- Bulk Actions -->
                @if(!request()->routeIs('family-members.archived'))
                    <button class="btn btn-danger" id="bulkDeleteBtn" style="display: none;" onclick="bulkAction('delete')">
                        <i class="fas fa-trash"></i>
                        Archive Selected (0)
                    </button>
                @else
                    <button class="btn btn-success" id="bulkRestoreBtn" style="display: none;" onclick="bulkAction('restore')">
                        <i class="fas fa-trash-restore"></i>
                        Restore Selected (0)
                    </button>
                    @if($userRole === 'admin')
                        <button class="btn btn-danger" id="bulkForceDeleteBtn" style="display: none;" onclick="bulkAction('force-delete')">
                            <i class="fas fa-trash"></i>
                            Delete Permanently (0)
                        </button>
                    @endif
                @endif
            </div>
        </div>

        <div class="table-responsive">
            @php
                if(request()->routeIs('family-members.archived')) {
                    $familyMembers = App\Models\FamilyMember::onlyTrashed()
                        ->with(['resident', 'relation'])
                        ->latest('deleted_at')
                        ->get();
                } else {
                    $familyMembers = App\Models\FamilyMember::with(['resident', 'relation'])
                        ->when(request('resident_id'), function($query) {
                            return $query->where('resident_id', request('resident_id'));
                        })
                        ->when(request('search'), function($query) {
                            $search = request('search');
                            return $query->where(function($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%")
                                  ->orWhere('mobile', 'like', "%{$search}%")
                                  ->orWhereHas('relation', function($r) use ($search) {
                                      $r->where('name', 'like', "%{$search}%");
                                  })
                                  ->orWhereHas('resident', function($r) use ($search) {
                                      $r->where('name', 'like', "%{$search}%");
                                  });
                            });
                        })
                        ->latest()
                        ->get();
                }
            @endphp

            @if($familyMembers->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h6>{{ request()->routeIs('family-members.archived') ? 'No archived family members found' : 'No family members found' }}</h6>
                    @if(!request()->routeIs('family-members.archived') && in_array($userRole, ['admin', 'resident']))
                        <a href="{{ route('family-members.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Add Your First Family Member
                        </a>
                    @endif
                </div>
            @else
                <table id="familyTable" class="family-table">
                    <thead>
                        <tr>
                            <th width="40">
                                <div class="checkbox-wrapper">
                                    <div class="checkbox-custom" id="selectAll" onclick="toggleSelectAll()"></div>
                                </div>
                            </th>
                            <th>#</th>
                            <th>Member</th>
                            <th>Relation</th>
                            <th>Contact</th>
                            <th>Resident</th>
                            <th>Flat</th>
                            <th>Added On</th>
                            @if(request()->routeIs('family-members.archived'))
                                <th>Deleted On</th>
                            @endif
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($familyMembers as $key => $member)
                            @php
                                $isOwnFamily = (!$member->trashed() && $loggedInResidentId && $loggedInResidentId == $member->resident_id);
                                $relationClass = strtolower($member->relation->name ?? 'other');
                                $relationIcon = match($relationClass) {
                                    'father' => 'fa-male',
                                    'mother' => 'fa-female',
                                    'son' => 'fa-male',
                                    'daughter' => 'fa-female',
                                    'spouse' => 'fa-heart',
                                    default => 'fa-user'
                                };

                                $canEdit = $userRole === 'admin' || ($userRole === 'resident' && $isOwnFamily);
                                $canDelete = $userRole === 'admin' || ($userRole === 'resident' && $isOwnFamily);
                                $canRestore = $userRole === 'admin' || ($userRole === 'resident' && $member->resident_id == $loggedInResidentId);
                                $canForceDelete = $userRole === 'admin';
                            @endphp
                            <tr id="row-{{ $member->member_id }}"
                                class="{{ $member->trashed() ? 'deleted-row' : ($isOwnFamily ? 'own-family-row' : '') }}">
                                <td>
                                    <div class="checkbox-wrapper">
                                        <div class="checkbox-custom row-checkbox"
                                             data-id="{{ $member->member_id }}"
                                             onclick="toggleRow(this)"></div>
                                    </div>
                                </td>
                                <td>
                                    <span style="color: var(--secondary);">{{ $key + 1 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="member-avatar me-2">
                                            <i class="fas {{ $relationIcon }}"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 600;">
                                                {{ $member->name ?? '-' }}
                                                @if($member->trashed())
                                                    <span class="archived-badge">Archived</span>
                                                @elseif($isOwnFamily)
                                                    <span class="own-family-badge">Your Family</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="relation-badge {{ $relationClass }}">
                                        <i class="fas {{ $relationIcon }}"></i>
                                        {{ $member->relation->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($member->mobile)
                                        <div style="font-weight: 500;">
                                            <i class="fas fa-phone-alt text-success me-1"></i>
                                            {{ $member->mobile }}
                                        </div>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 500;">{{ $member->resident->name ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <span class="resident-badge">
                                        <i class="fas fa-home"></i>
                                        {{ $member->resident->flat_no ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-size: 0.8rem; color: var(--secondary);">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ $member->created_at ? $member->created_at->format('d M Y') : 'N/A' }}
                                    </div>
                                </td>
                                @if(request()->routeIs('family-members.archived'))
                                <td>
                                    <div style="font-size: 0.8rem; color: var(--danger);">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $member->deleted_at ? $member->deleted_at->format('d M Y') : 'N/A' }}
                                    </div>
                                </td>
                                @endif
                                <td>
                                    <div class="action-group">
                                        @if(!$member->trashed())
                                            <!-- View -->
                                            <a href="{{ route('family-members.show', $member->member_id) }}" class="action-btn view" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($canEdit)
                                                <!-- Edit -->
                                                <a href="{{ route('family-members.edit', $member->member_id) }}" class="action-btn edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            @if($canDelete)
                                                <!-- Archive -->
                                                <form action="{{ route('family-members.destroy', $member->member_id) }}"
                                                      method="POST"
                                                      class="d-inline delete-form"
                                                      onsubmit="return confirmArchive('{{ $member->name }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn delete" title="Archive">
                                                        <i class="fas fa-archive"></i>
                                                    </button>
                                                </form>
                                            @elseif($userRole === 'resident' && !$isOwnFamily)
                                                <span class="action-btn delete disabled" title="Cannot archive others' family members">
                                                    <i class="fas fa-archive"></i>
                                                </span>
                                            @endif
                                        @else
                                            <!-- View (even archived) -->
                                            <a href="{{ route('family-members.show', $member->member_id) }}" class="action-btn view" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($canRestore)
                                                <!-- Restore -->
                                                <form action="{{ route('family-members.restore', $member->member_id) }}"
                                                      method="POST"
                                                      class="d-inline restore-form"
                                                      onsubmit="return confirmRestore('{{ $member->name }}')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="action-btn restore" title="Restore">
                                                        <i class="fas fa-trash-restore"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($canForceDelete)
                                                <!-- Force Delete -->
                                                <form action="{{ route('family-members.force-delete', $member->member_id) }}"
                                                      method="POST"
                                                      class="d-inline force-delete-form"
                                                      onsubmit="return confirmForceDelete('{{ $member->name }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn delete" title="Delete Permanently">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Action Form -->
<form id="bulkActionForm" method="POST" style="display: none;">
    @csrf
    @method('POST')
    <input type="hidden" name="ids" id="selectedIds">
    <input type="hidden" name="action" id="bulkAction">
</form>

@endsection

@push('scripts')
<!-- SheetJS for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<!-- jsPDF for PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<!-- AutoTable for PDF tables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let selectedRows = new Set();

    document.addEventListener('DOMContentLoaded', function() {
        // Load saved selections from localStorage
        const saved = localStorage.getItem('selectedRows');
        if (saved) {
            selectedRows = new Set(JSON.parse(saved));
            updateUI();
        }
    });

    // Confirm archive
    function confirmArchive(name) {
        return Swal.fire({
            title: 'Archive Family Member?',
            text: `Are you sure you want to archive ${name}? It can be restored later.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, archive it!'
        }).then((result) => {
            return result.isConfirmed;
        });
    }

    // Confirm restore
    function confirmRestore(name) {
        return Swal.fire({
            title: 'Restore Family Member?',
            text: `Restore ${name} to active members?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            return result.isConfirmed;
        });
    }

    // Confirm force delete
    function confirmForceDelete(name) {
        return Swal.fire({
            title: 'Permanently Delete?',
            text: `This will permanently delete ${name}. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete permanently!'
        }).then((result) => {
            return result.isConfirmed;
        });
    }

    // Filter functions
    function filterByResident(residentId) {
        if (residentId) {
            window.location.href = "{{ route('family-members.index') }}?resident_id=" + residentId;
        } else {
            window.location.href = "{{ route('family-members.index') }}";
        }
    }

    function applyFilters() {
        const residentId = document.getElementById('residentFilter').value;
        const search = document.getElementById('searchInput').value;
        let url = "{{ route('family-members.index') }}?";
        let params = [];
        if (residentId) params.push('resident_id=' + residentId);
        if (search) params.push('search=' + encodeURIComponent(search));
        window.location.href = url + params.join('&');
    }

    // Toggle Select All
    function toggleSelectAll() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.row-checkbox');

        if (selectedRows.size === checkboxes.length) {
            // Deselect all
            selectedRows.clear();
            selectAll.classList.remove('checked');
            checkboxes.forEach(cb => cb.classList.remove('checked'));
        } else {
            // Select all
            checkboxes.forEach(cb => {
                const id = cb.dataset.id;
                selectedRows.add(id);
                cb.classList.add('checked');
            });
            selectAll.classList.add('checked');
        }

        updateUI();
    }

    // Toggle individual row
    function toggleRow(element) {
        const id = element.dataset.id;

        if (selectedRows.has(id)) {
            selectedRows.delete(id);
            element.classList.remove('checked');
        } else {
            selectedRows.add(id);
            element.classList.add('checked');
        }

        // Update select all checkbox
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.row-checkbox');

        if (selectedRows.size === checkboxes.length) {
            selectAll.classList.add('checked');
        } else {
            selectAll.classList.remove('checked');
        }

        updateUI();
    }

    // Update UI based on selections
    function updateUI() {
        const count = selectedRows.size;
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const bulkRestoreBtn = document.getElementById('bulkRestoreBtn');
        const bulkForceDeleteBtn = document.getElementById('bulkForceDeleteBtn');
        const isArchive = {{ request()->routeIs('family-members.archived') ? 'true' : 'false' }};

        if (count > 0) {
            if (isArchive) {
                if (bulkRestoreBtn) {
                    bulkRestoreBtn.style.display = 'inline-flex';
                    bulkRestoreBtn.innerHTML = `<i class="fas fa-trash-restore"></i> Restore Selected (${count})`;
                }
                if (bulkForceDeleteBtn) {
                    bulkForceDeleteBtn.style.display = 'inline-flex';
                    bulkForceDeleteBtn.innerHTML = `<i class="fas fa-trash"></i> Delete Permanently (${count})`;
                }
                if (bulkDeleteBtn) bulkDeleteBtn.style.display = 'none';
            } else {
                if (bulkDeleteBtn) {
                    bulkDeleteBtn.style.display = 'inline-flex';
                    bulkDeleteBtn.innerHTML = `<i class="fas fa-trash"></i> Archive Selected (${count})`;
                }
                if (bulkRestoreBtn) bulkRestoreBtn.style.display = 'none';
                if (bulkForceDeleteBtn) bulkForceDeleteBtn.style.display = 'none';
            }
        } else {
            if (bulkDeleteBtn) bulkDeleteBtn.style.display = 'none';
            if (bulkRestoreBtn) bulkRestoreBtn.style.display = 'none';
            if (bulkForceDeleteBtn) bulkForceDeleteBtn.style.display = 'none';
        }

        // Save to localStorage
        localStorage.setItem('selectedRows', JSON.stringify([...selectedRows]));
    }

    // Bulk Action
    function bulkAction(action) {
        if (selectedRows.size === 0) return;

        let message = '';
        if (action === 'delete') {
            message = `Archive ${selectedRows.size} selected family member(s)? They can be restored later.`;
        } else if (action === 'restore') {
            message = `Restore ${selectedRows.size} selected family member(s)?`;
        } else if (action === 'force-delete') {
            message = `Permanently delete ${selectedRows.size} selected family member(s)? This action cannot be undone!`;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: action === 'restore' ? '#10b981' : '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('bulkActionForm');
                const ids = [...selectedRows].join(',');

                if (action === 'delete') {
                    form.action = '{{ route("family-members.bulk-delete") }}';
                } else if (action === 'restore') {
                    form.action = '{{ route("family-members.bulk-restore") }}';
                } else if (action === 'force-delete') {
                    form.action = '{{ route("family-members.bulk-force-delete") }}';
                }

                document.getElementById('selectedIds').value = ids;
                document.getElementById('bulkAction').value = action;
                form.submit();
            }
        });
    }

    // Show Notification
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}" style="color: ${type === 'success' ? 'var(--success)' : 'var(--danger)'};"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideIn 0.3s reverse';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Export Table
    function exportTable(format) {
        const table = document.getElementById('familyTable');
        const data = [];

        // Get headers
        const headers = [];
        table.querySelectorAll('thead th').forEach((th, index) => {
            if (index > 0 && index < 8) { // Skip checkbox and actions columns
                headers.push(th.textContent.trim());
            }
        });
        data.push(headers);

        // Get data
        table.querySelectorAll('tbody tr').forEach(row => {
            const rowData = [];
            const cells = row.querySelectorAll('td');

            rowData.push(cells[1].textContent.trim()); // #
            rowData.push(cells[2].textContent.trim().replace(/\s+/g, ' ')); // Member
            rowData.push(cells[3].textContent.trim()); // Relation
            rowData.push(cells[4].textContent.trim()); // Contact
            rowData.push(cells[5].textContent.trim()); // Resident
            rowData.push(cells[6].textContent.trim()); // Flat
            rowData.push(cells[7].textContent.trim()); // Added On

            data.push(rowData);
        });

        if (format === 'excel') {
            exportToExcel(data);
        } else if (format === 'pdf') {
            exportToPDF(data);
        }
    }

    // Export to Excel
    function exportToExcel(data) {
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(data);
        XLSX.utils.book_append_sheet(wb, ws, 'Family Members');
        XLSX.writeFile(wb, `family_members_${new Date().toISOString().split('T')[0]}.xlsx`);
    }

    // Export to PDF
    function exportToPDF(data) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('landscape');

        doc.setFontSize(16);
        doc.setTextColor(37, 99, 235);
        doc.text('Family Members List', 14, 20);

        doc.setFontSize(10);
        doc.setTextColor(100, 116, 139);
        doc.text(`Generated: ${new Date().toLocaleDateString()}`, 14, 28);

        doc.autoTable({
            head: [data[0]],
            body: data.slice(1),
            startY: 35,
            theme: 'striped',
            headStyles: {
                fillColor: [37, 99, 235],
                textColor: [255, 255, 255],
                fontStyle: 'bold'
            },
            styles: {
                fontSize: 9,
                cellPadding: 5
            }
        });

        doc.save(`family_members_${new Date().toISOString().split('T')[0]}.pdf`);
    }

    // Show success message from session
    @if(session('success'))
        showNotification('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
        showNotification('{{ session('error') }}', 'error');
    @endif

    // Clear selections on page unload
    window.addEventListener('beforeunload', function() {
        localStorage.removeItem('selectedRows');
    });
</script>
@endpush
