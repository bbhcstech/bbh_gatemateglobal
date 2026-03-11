@extends('admin.layout.app')

@section('title', 'Complaint Management')

@section('content')
<style>
    /* Clean & Professional Theme - Exactly matching Pet Management */
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
    .stat-icon.pending { background: #fff3cd; color: #856404; }
    .stat-icon.progress { background: #d1ecf1; color: #0c5460; }
    .stat-icon.resolved { background: #d4edda; color: #155724; }

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

    /* Filter Card */
    .filter-card {
        background: white;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .filter-grid {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-item {
        flex: 1;
        min-width: 200px;
    }

    .filter-item label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 0.5rem;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-item input,
    .filter-item select {
        width: 100%;
        padding: 0.625rem 1rem;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .filter-item input:focus,
    .filter-item select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .filter-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
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

    .btn-warning {
        background: white;
        border-color: var(--border);
        color: var(--warning);
    }

    .btn-warning:hover {
        background: #fff3cd;
        border-color: var(--warning);
    }

    .btn-success {
        background: white;
        border-color: var(--border);
        color: var(--success);
    }

    .btn-success:hover {
        background: #d4edda;
        border-color: var(--success);
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

    .complaint-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.5rem;
        min-width: 1200px;
    }

    .complaint-table thead th {
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

    .complaint-table tbody tr {
        background: white;
        border-radius: 12px;
        transition: all 0.2s;
    }

    .complaint-table tbody tr:hover {
        background: #f8fafc;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .complaint-table tbody td {
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

    /* Status Badge */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        text-transform: capitalize;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-progress {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-resolved {
        background: #d4edda;
        color: #155724;
    }

    /* Priority Badge - Like Vaccination Badge in Pets */
    .priority-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        white-space: nowrap;
    }

    .priority-badge.high {
        background: #fee2e2;
        color: #dc2626;
    }

    .priority-badge.medium {
        background: #fff3cd;
        color: #d97706;
    }

    .priority-badge.low {
        background: #d1fae5;
        color: #059669;
    }

    /* Status Dropdown */
    .status-dropdown {
        position: relative;
        display: inline-block;
    }

    .status-select {
        padding: 0.25rem 1.5rem 0.25rem 0.75rem;
        border-radius: 20px;
        border: 1px solid var(--border);
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L2 4h8z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
    }

    .status-select.pending { background: #fff3cd; color: #856404; border-color: #856404; }
    .status-select.progress { background: #d1ecf1; color: #0c5460; border-color: #0c5460; }
    .status-select.resolved { background: #d4edda; color: #155724; border-color: #155724; }

    /* Type Badge */
    .type-badge {
        background: #f1f5f9;
        color: var(--secondary);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
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

    /* Resident Info - Like Owner & Flat in Pets */
    .resident-info {
        display: flex;
        flex-direction: column;
    }

    .resident-name {
        font-weight: 600;
        color: var(--dark);
    }

    .resident-flat {
        font-size: 0.75rem;
        color: var(--secondary);
    }

    /* Flat Style - Like Microchip in Pets */
    .flat-badge {
        font-size: 0.7rem;
        color: var(--secondary);
        background: #f1f5f9;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        display: inline-block;
        margin-top: 0.15rem;
    }

    /* Description Cell */
    .description-cell {
        max-width: 250px;
    }

    .description-text {
        font-size: 0.875rem;
        color: var(--dark);
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .description-preview {
        font-size: 0.7rem;
        color: var(--secondary);
        display: flex;
        align-items: center;
        gap: 0.25rem;
        cursor: pointer;
    }

    .description-preview:hover {
        color: var(--primary);
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

    /* Warning Text */
    .warning-text {
        color: var(--warning);
        font-size: 0.7rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Attachment Style */
    .attachment-badge {
        font-size: 0.7rem;
        color: var(--secondary);
        background: #f1f5f9;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        display: inline-block;
        margin-top: 0.15rem;
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
</style>

@php
    $totalComplaints = $complaints->count();
    $pendingCount = $complaints->where('status', 'pending')->count();
    $inProgressCount = $complaints->where('status', 'in progress')->count();
    $resolvedCount = $complaints->where('status', 'resolved')->count();

    $isAdmin = auth()->check() && strtolower(optional(auth()->user()->roleMaster)->role_name) === 'admin';
    $isResident = auth()->check() && strtolower(optional(auth()->user()->roleMaster)->role_name) === 'resident';
@endphp

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="header-title">
            <h2>
                <i class="fas fa-ticket-alt me-2" style="color: var(--primary);"></i>
                Complaint Management
            </h2>
            <p>Manage and track all resident complaints and tickets</p>
        </div>
        <div class="toolbar">
            <!-- View All Residents Complaints Button (Only for Residents) - Like View All Residents Pets -->
            @if($isResident)
                <a href="{{ route('complaints.all-residents') }}" class="btn btn-info">
                    <i class="fas fa-users me-2"></i>
                    View All Residents' Complaints
                </a>
            @endif

            <!-- Archive Button -->
            @if($isAdmin)
                <a href="{{ route('complaints.archived') }}" class="btn btn-outline">
                    <i class="fas fa-archive me-2"></i>
                    View Archive
                </a>
            @endif

            <!-- Add Complaint Button -->
            @if($isResident || $isAdmin)
                <a href="{{ route('complaints.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Raise Complaint
                </a>
            @endif
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-info">
                <h6>Total Complaints</h6>
                <h3 id="totalComplaints">{{ $totalComplaints }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h6>Pending</h6>
                <h3 id="pendingCount">{{ $pendingCount }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon progress">
                <i class="fas fa-spinner"></i>
            </div>
            <div class="stat-info">
                <h6>In Progress</h6>
                <h3 id="inProgressCount">{{ $inProgressCount }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon resolved">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h6>Resolved</h6>
                <h3 id="resolvedCount">{{ $resolvedCount }}</h3>
            </div>
        </div>
    </div>

    <!-- Filter Card - New feature but matching style -->
    <div class="filter-card">
        <form method="GET" action="{{ route('complaints.index') }}" id="filterForm">
            <div class="filter-grid">
                <div class="filter-item">
                    <label for="date_range">Date Range</label>
                    <input type="text"
                           class="form-control"
                           id="date_range"
                           name="date_range"
                           value="{{ request('date_range') }}"
                           placeholder="Select Date Range"
                           autocomplete="off">
                </div>
                <div class="filter-item">
                    <label for="status">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in progress" {{ request('status') == 'in progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="priority">Priority</label>
                    <select class="form-select" id="priority" name="priority">
                        <option value="">All Priorities</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="type">Complaint Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">All Types</option>
                        <option value="maintenance" {{ request('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="noise" {{ request('type') == 'noise' ? 'selected' : '' }}>Noise</option>
                        <option value="security" {{ request('type') == 'security' ? 'selected' : '' }}>Security</option>
                        <option value="cleanliness" {{ request('type') == 'cleanliness' ? 'selected' : '' }}>Cleanliness</option>
                        <option value="amenities" {{ request('type') == 'amenities' ? 'selected' : '' }}>Amenities</option>
                        <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>
                    <a href="{{ route('complaints.index') }}" class="btn btn-outline">
                        <i class="fas fa-redo"></i>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-list"></i>
                Active Complaints
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
                <!-- Bulk Actions (Only for Admin) -->
                @if($isAdmin)
                    <button class="btn btn-danger" id="bulkDeleteBtn" style="display: none;" onclick="bulkAction('delete')">
                        <i class="fas fa-trash"></i>
                        Archive Selected (0)
                    </button>
                    <button class="btn btn-warning" id="bulkStatusBtn" style="display: none;" onclick="showBulkStatusModal()">
                        <i class="fas fa-edit"></i>
                        Change Status (0)
                    </button>
                @endif
            </div>
        </div>

        <div class="table-responsive">
            @if($complaints->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h6>No complaints found</h6>
                    @if($isResident || $isAdmin)
                        <a href="{{ route('complaints.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Raise Your First Complaint
                        </a>
                    @endif
                </div>
            @else
                <table id="complaintsTable" class="complaint-table">
                    <thead>
                        <tr>
                            @if($isAdmin)
                                <th width="40">
                                    <div class="checkbox-wrapper">
                                        <div class="checkbox-custom" id="selectAll" onclick="toggleSelectAll()"></div>
                                    </div>
                                </th>
                            @endif
                            <th>#</th>
                            <th>Complaint Details</th>
                            @if($isAdmin)
                                <th>Resident & Flat</th>
                            @endif
                            <th>Type</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Submitted On</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($complaints as $key => $complaint)
                            <tr id="row-{{ $complaint->id }}">
                                @if($isAdmin)
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <div class="checkbox-custom row-checkbox"
                                                 data-id="{{ $complaint->id }}"
                                                 onclick="toggleRow(this)"></div>
                                        </div>
                                    </td>
                                @endif
                                <td>
                                    <span style="color: var(--secondary);">{{ $key + 1 }}</span>
                                </td>
                                <td class="description-cell">
                                    <div style="font-weight: 600;">{{ $complaint->title ?? 'Complaint' }}</div>
                                    <div style="font-size: 0.75rem; color: var(--secondary);">
                                        {{ Str::limit($complaint->description, 50) }}
                                    </div>
                                    @if(strlen($complaint->description) > 50)
                                        <div class="description-preview" onclick="showDescription('{{ addslashes($complaint->description) }}')">
                                            <i class="fas fa-eye"></i> View Full Description
                                        </div>
                                    @endif
                                    @if($complaint->attachment)
                                        <div class="attachment-badge">
                                            <i class="fas fa-paperclip"></i>
                                            <a href="{{ asset('storage/' . $complaint->attachment) }}" target="_blank">Attachment</a>
                                        </div>
                                    @endif
                                </td>
                                @if($isAdmin)
                                    <td>
                                        <div style="font-weight: 500;">{{ $complaint->resident->name ?? 'N/A' }}</div>
                                        @if($complaint->resident && $complaint->resident->flat)
                                            <div style="font-size: 0.75rem; color: var(--secondary);">
                                                <i class="fas fa-home me-1"></i>
                                                Flat: {{ $complaint->resident->flat->flat_no ?? 'N/A' }}
                                            </div>
                                        @endif
                                        @if($complaint->resident && $complaint->resident->phone)
                                            <div class="flat-badge">
                                                <i class="fas fa-phone"></i>
                                                {{ $complaint->resident->phone }}
                                            </div>
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    <span class="type-badge">
                                        {{ ucfirst($complaint->type ?? 'General') }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $priorityClass = $complaint->priority ?? 'medium';
                                    @endphp
                                    <span class="priority-badge {{ $priorityClass }}">
                                        <i class="fas fa-{{ $priorityClass == 'high' ? 'exclamation-circle' : ($priorityClass == 'medium' ? 'minus-circle' : 'arrow-down-circle') }}"></i>
                                        {{ ucfirst($priorityClass) }}
                                    </span>
                                </td>
                                <td>
                                    @if($isAdmin)
                                        <div class="status-dropdown">
                                            <select class="status-select {{ str_replace(' ', '', $complaint->status) }}"
                                                    data-complaint-id="{{ $complaint->id }}"
                                                    onchange="updateStatus(this, {{ $complaint->id }})">
                                                <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="in progress" {{ $complaint->status == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                            </select>
                                        </div>
                                    @else
                                        @php
                                            $statusClass = match($complaint->status) {
                                                'pending' => 'status-pending',
                                                'in progress' => 'status-progress',
                                                'resolved' => 'status-resolved',
                                                default => 'status-pending'
                                            };
                                            $statusIcon = match($complaint->status) {
                                                'pending' => 'clock',
                                                'in progress' => 'spinner',
                                                'resolved' => 'check-circle',
                                                default => 'clock'
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            <i class="fas fa-{{ $statusIcon }}"></i>
                                            {{ ucfirst($complaint->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 500;">{{ $complaint->created_at->format('d M Y') }}</div>
                                    <div style="font-size: 0.7rem; color: var(--secondary);">
                                        {{ $complaint->created_at->format('h:i A') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <!-- View -->
                                        <a href="{{ route('complaints.show', $complaint->id) }}" class="action-btn view" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @php
                                            $canEdit = $isAdmin || ($isResident && $complaint->resident_id == auth()->id() && $complaint->status != 'resolved');
                                            $canDelete = $isAdmin;
                                            $canConfirmResolve = $isResident && $complaint->resident_id == auth()->id() && $complaint->status == 'resolved' && !$complaint->confirmed_by_resident;
                                        @endphp

                                        @if($canEdit)
                                            <!-- Edit -->
                                            <a href="{{ route('complaints.edit', $complaint->id) }}" class="action-btn edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif

                                        @if($canDelete)
                                            <!-- Delete (Archive) -->
                                            <form action="{{ route('complaints.destroy', $complaint->id) }}"
                                                  method="POST"
                                                  class="d-inline delete-form"
                                                  onsubmit="return confirm('Archive this complaint? It can be restored later.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete" title="Archive">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if($canConfirmResolve)
                                            <!-- Confirm Resolved (for residents) - Like confirming vaccination -->
                                            <button class="action-btn success" title="Confirm Resolved" onclick="confirmResolution({{ $complaint->id }})">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        @endif

                                        @if($isResident && $complaint->resident_id == auth()->id() && $complaint->status == 'pending')
                                            <span class="action-btn disabled" title="Waiting for admin response">
                                                <i class="fas fa-hourglass-half"></i>
                                            </span>
                                            <div class="warning-text">
                                                <i class="fas fa-info-circle"></i> Awaiting response
                                            </div>
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

<!-- Description Modal -->
<div class="modal fade" id="descriptionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-align-left me-2" style="color: var(--primary);"></i>
                    Full Description
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="fullDescription" style="white-space: pre-wrap;"></p>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Status Modal -->
<div class="modal fade" id="bulkStatusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2" style="color: var(--primary);"></i>
                    Change Status for Selected Complaints
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="bulkNewStatus" class="form-label">Select New Status</label>
                    <select class="form-select" id="bulkNewStatus">
                        <option value="pending">Pending</option>
                        <option value="in progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="bulkUpdateStatus()">Update Status</button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Action Form -->
<form id="bulkActionForm" method="POST" style="display: none;">
    @csrf
    @method('POST')
    <input type="hidden" name="ids" id="selectedIds">
    <input type="hidden" name="status" id="bulkStatusValue">
</form>

@endsection

@push('scripts')
<!-- SheetJS for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<!-- jsPDF for PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<!-- AutoTable for PDF tables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<!-- Moment.js for date handling -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<!-- Daterangepicker -->
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<script>
    let selectedRows = new Set();
    let descriptionModal;
    let bulkStatusModal;

    document.addEventListener('DOMContentLoaded', function() {
        descriptionModal = new bootstrap.Modal(document.getElementById('descriptionModal'));
        bulkStatusModal = new bootstrap.Modal(document.getElementById('bulkStatusModal'));

        // Load saved selections from localStorage
        const saved = localStorage.getItem('selectedComplaintRows');
        if (saved) {
            selectedRows = new Set(JSON.parse(saved));
            updateUI();
        }

        // Initialize daterangepicker
        $('#date_range').daterangepicker({
            autoUpdateInput: false,
            showDropdowns: true,
            opens: 'left',
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            },
            ranges: {
                'Today': [moment(), moment()],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });

        $('#date_range').on('apply.daterangepicker', function(ev, picker) {
            if (picker.chosenLabel === 'Custom Range') {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
            } else {
                $(this).val(picker.chosenLabel);
            }
        });

        $('#date_range').on('cancel.daterangepicker', function() {
            $(this).val('');
        });
    });

    // Show full description
    function showDescription(description) {
        document.getElementById('fullDescription').textContent = description;
        descriptionModal.show();
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
        const bulkStatusBtn = document.getElementById('bulkStatusBtn');

        if (count > 0) {
            if (bulkDeleteBtn) {
                bulkDeleteBtn.style.display = 'inline-flex';
                bulkDeleteBtn.innerHTML = `<i class="fas fa-trash"></i> Archive Selected (${count})`;
            }
            if (bulkStatusBtn) {
                bulkStatusBtn.style.display = 'inline-flex';
                bulkStatusBtn.innerHTML = `<i class="fas fa-edit"></i> Change Status (${count})`;
            }
        } else {
            if (bulkDeleteBtn) bulkDeleteBtn.style.display = 'none';
            if (bulkStatusBtn) bulkStatusBtn.style.display = 'none';
        }

        // Save to localStorage
        localStorage.setItem('selectedComplaintRows', JSON.stringify([...selectedRows]));
    }

    // Bulk Delete
    function bulkAction(action) {
        if (selectedRows.size === 0) return;

        const message = `Archive ${selectedRows.size} selected complaint(s)? They can be restored later.`;

        if (!confirm(message)) return;

        const form = document.getElementById('bulkActionForm');
        const ids = [...selectedRows].join(',');

        form.action = '{{ route("complaints.bulk-delete") }}';
        document.getElementById('selectedIds').value = ids;
        form.submit();
    }

    // Show Bulk Status Modal
    function showBulkStatusModal() {
        if (selectedRows.size === 0) return;
        bulkStatusModal.show();
    }

    // Bulk Update Status
    function bulkUpdateStatus() {
        const status = document.getElementById('bulkNewStatus').value;
        if (!status) return;

        const ids = [...selectedRows].join(',');
        const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        fetch('{{ route("complaints.bulk-status") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                ids: ids,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Status updated successfully for selected complaints', 'success');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Failed to update status', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating status', 'error');
        })
        .finally(() => {
            bulkStatusModal.hide();
        });
    }

    // Update Status
    function updateStatus(selectElement, complaintId) {
        const status = selectElement.value;
        const originalClass = selectElement.className;
        const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        // Show loading state
        selectElement.disabled = true;
        selectElement.style.opacity = '0.6';

        fetch(`{{ url('complaints') }}/${complaintId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                status: status
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update select styling
                selectElement.className = `status-select ${status.replace(' ', '')}`;

                // Update the stats counters with the new counts from server
                if (data.counts) {
                    document.getElementById('totalComplaints').textContent = data.counts.total;
                    document.getElementById('pendingCount').textContent = data.counts.pending;
                    document.getElementById('inProgressCount').textContent = data.counts.in_progress;
                    document.getElementById('resolvedCount').textContent = data.counts.resolved;
                }

                // Show success message
                showNotification('Status updated successfully', 'success');

                // Reload page after 1 second
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // Restore original state
            selectElement.className = originalClass;
            showNotification(error.message || 'Failed to update status', 'error');
        })
        .finally(() => {
            // Remove loading state
            selectElement.disabled = false;
            selectElement.style.opacity = '1';
        });
    }

    // Confirm Resolution (for residents)
    function confirmResolution(complaintId) {
        if (!confirm('Have you confirmed that the issue has been resolved? This will close the ticket.')) return;

        const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        fetch(`{{ url('complaints') }}/${complaintId}/confirm-resolution`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Thank you for confirming! Ticket closed.', 'success');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Error confirming resolution', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error confirming resolution', 'error');
        });
    }

    // Show Notification
    function showNotification(message, type = 'success') {
        // Remove any existing notification
        const existingNotification = document.querySelector('.notification');
        if (existingNotification) {
            existingNotification.remove();
        }

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}" style="color: ${type === 'success' ? 'var(--success)' : 'var(--danger)'};"></i>
                <span>${message}</span>
            </div>
        `;

        // Add to document
        document.body.appendChild(notification);

        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideIn 0.3s reverse';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Export Table
    function exportTable(format) {
        const table = document.getElementById('complaintsTable');
        const data = [];

        // Get headers
        const headers = [];
        table.querySelectorAll('thead th').forEach((th, index) => {
            @if($isAdmin)
                if (index > 0 && index < 8) { // Skip checkbox and actions columns
                    headers.push(th.textContent.trim());
                }
            @else
                if (index < 7) { // All columns except checkbox
                    headers.push(th.textContent.trim());
                }
            @endif
        });
        data.push(headers);

        // Get data
        table.querySelectorAll('tbody tr').forEach(row => {
            const rowData = [];
            const cells = row.querySelectorAll('td');

            @if($isAdmin)
                // Start from index 1 to skip checkbox
                for (let i = 1; i < cells.length - 1; i++) { // Skip last column (actions)
                    let cellText = cells[i].textContent.trim().replace(/\s+/g, ' ');
                    rowData.push(cellText);
                }
            @else
                for (let i = 0; i < cells.length - 1; i++) { // Skip last column (actions)
                    let cellText = cells[i].textContent.trim().replace(/\s+/g, ' ');
                    rowData.push(cellText);
                }
            @endif

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
        XLSX.utils.book_append_sheet(wb, ws, 'Complaints');
        XLSX.writeFile(wb, `complaints_${new Date().toISOString().split('T')[0]}.xlsx`);
    }

    // Export to PDF
    function exportToPDF(data) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('landscape');

        doc.setFontSize(16);
        doc.setTextColor(37, 99, 235);
        doc.text('Complaints List', 14, 20);

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

        doc.save(`complaints_${new Date().toISOString().split('T')[0]}.pdf`);
    }

    // Clear selections on page unload
    window.addEventListener('beforeunload', function() {
        localStorage.removeItem('selectedComplaintRows');
    });
</script>
@endpush
