@extends('admin.layout.app')

@section('title', 'Vehicle Management')

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
    .stat-icon.approved { background: #d1fae5; color: var(--success); }
    .stat-icon.pending { background: #fed7aa; color: var(--warning); }
    .stat-icon.parking { background: #e2e8f0; color: var(--secondary); }

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
    }

    .vehicle-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.5rem;
    }

    .vehicle-table thead th {
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
        color: var(--dark);
        font-size: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
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

    /* Vehicle Image */
    .vehicle-thumb {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid var(--border);
        transition: all 0.2s;
    }

    .vehicle-thumb:hover {
        border-color: var(--primary);
        transform: scale(1.1);
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

    .status-active {
        background: #d1fae5;
        color: #059669;
    }

    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
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

    .status-select.active { background: #d1fae5; color: #059669; border-color: #059669; }
    .status-select.inactive { background: #fee2e2; color: #dc2626; border-color: #dc2626; }

    /* Action Buttons */
    .action-group {
        display: flex;
        gap: 0.5rem;
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
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="header-title">
            <h2>
                <i class="fas fa-car me-2" style="color: var(--primary);"></i>
                Vehicle Management
            </h2>
            <p>Manage all resident vehicles and parking assignments</p>
        </div>
        <!-- In the header section of your index.blade.php, update the toolbar -->
            <div div class="toolbar">
                <!-- Archive Button -->
            <a href="{{ route('vehicles.archived') }}" class="btn btn-outline">
                    <i class="fas fa-archive me-2"></i>
                    View Archive 
                </a>

                <!-- Add Vehicle Button -->
                @if(auth()->check() && in_array(strtolower(optional(auth()->user()->roleMaster)->role_name), ['admin', 'resident']))
                    <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Add Vehicle
                    </a>
                @endif
</div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-car"></i>
            </div>
            <div class="stat-info">
                <h6>Total Vehicles</h6>
                <h3 id="totalVehicles">{{ $totalVehicles ?? $vehicles->count() }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon approved">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h6>Active</h6>
                <h3 id="activeCount">{{ $activeCount ?? $vehicles->where('status', 'active')->count() }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h6>Inactive</h6>
                <h3 id="inactiveCount">{{ $inactiveCount ?? $vehicles->where('status', 'inactive')->count() }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon parking">
                <i class="fas fa-parking"></i>
            </div>
            <div class="stat-info">
                <h6>Parking Assigned</h6>
                <h3 id="parkingAssigned">{{ $parkingAssigned ?? $vehicles->whereNotNull('parking_slot_id')->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-{{ request()->routeIs('vehicles.archived') ? 'archive' : 'list' }}"></i>
                {{ request()->routeIs('vehicles.archived') ? 'Archived Vehicles' : 'Active Vehicles' }}
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
                <button class="btn btn-danger" id="bulkDeleteBtn" style="display: none;" onclick="bulkAction('delete')">
                    <i class="fas fa-trash"></i>
                    Delete Selected (0)
                </button>
                <button class="btn btn-success" id="bulkRestoreBtn" style="display: none;" onclick="bulkAction('restore')">
                    <i class="fas fa-trash-restore"></i>
                    Restore Selected (0)
                </button>
            </div>
        </div>

        <div class="table-responsive">
            @if($vehicles->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h6>No vehicles found</h6>
                    @if(auth()->check() && in_array(strtolower(optional(auth()->user()->roleMaster)->role_name), ['admin', 'resident']))
                        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Add Your First Vehicle
                        </a>
                    @endif
                </div>
            @else
                <table id="vehiclesTable" class="vehicle-table">
                    <thead>
                        <tr>
                            <th width="40">
                                <div class="checkbox-wrapper">
                                    <div class="checkbox-custom" id="selectAll" onclick="toggleSelectAll()"></div>
                                </div>
                            </th>
                            <th>#</th>
                            <th>Image</th>
                            <th>Vehicle Details</th>
                            <th>Owner</th>
                            <th>Status</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $key => $vehicle)
                            <tr id="row-{{ $vehicle->id }}">
                                <td>
                                    <div class="checkbox-wrapper">
                                        <div class="checkbox-custom row-checkbox"
                                             data-id="{{ $vehicle->id }}"
                                             onclick="toggleRow(this)"></div>
                                    </div>
                                </td>
                                <td>
                                    <span style="color: var(--secondary);">{{ $key + 1 }}</span>
                                </td>
                                <td>
                                    @if($vehicle->vehicle_image)
                                        <img src="{{ asset($vehicle->vehicle_image) }}"
                                             class="vehicle-thumb"
                                             onclick="previewImage('{{ asset($vehicle->vehicle_image) }}')"
                                             alt="Vehicle">
                                    @else
                                        <div class="vehicle-thumb" style="background: var(--light); display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-car" style="color: var(--secondary);"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600;">{{ $vehicle->vehicle_number ?? '-' }}</div>
                                    <div style="font-size: 0.75rem; color: var(--secondary);">
                                        {{ $vehicle->vehicle_type ?? 'N/A' }}
                                        @if($vehicle->make || $vehicle->model)
                                            • {{ $vehicle->make ?? '' }} {{ $vehicle->model ?? '' }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 500;">{{ $vehicle->resident->name ?? $vehicle->owner_name ?? 'N/A' }}</div>
                                    @if($vehicle->resident && $vehicle->resident->flat)
                                        <div style="font-size: 0.75rem; color: var(--secondary);">
                                            <i class="fas fa-home me-1"></i>
                                            Flat: {{ $vehicle->resident->flat->flat_no ?? 'N/A' }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if(!$vehicle->trashed())
                                        <div class="status-dropdown">
                                            <select class="status-select {{ $vehicle->status ?? 'inactive' }}"
                                                    data-vehicle-id="{{ $vehicle->id }}"
                                                    data-parking-slot="{{ $vehicle->parking_slot_id ?? 'null' }}"
                                                    onchange="updateStatus(this, {{ $vehicle->id }})">
                                                <option value="active" {{ ($vehicle->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ ($vehicle->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-archive"></i>
                                            Archived
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-group">
                                        <!-- View -->
                                        <a href="{{ route('vehicles.show', $vehicle->id) }}" class="action-btn view" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if(!$vehicle->trashed())
                                            <!-- Edit -->
                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="action-btn edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Delete (Archive) -->
                                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Archive this vehicle? It can be restored later.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete" title="Archive">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Restore -->
                                            <form action="{{ route('vehicles.restore', $vehicle->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Restore this vehicle?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="action-btn restore" title="Restore">
                                                    <i class="fas fa-trash-restore"></i>
                                                </button>
                                            </form>

                                            <!-- Permanent Delete (Admin Only) -->
                                            @if(auth()->user()->role === 'resident')
                                                <form action="{{ route('vehicles.force-delete', $vehicle->id) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Permanently delete this vehicle? This cannot be undone!')">
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

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image me-2" style="color: var(--primary);"></i>
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

<script>
    let selectedRows = new Set();
    let imageModal;

    document.addEventListener('DOMContentLoaded', function() {
        imageModal = new bootstrap.Modal(document.getElementById('imageModal'));

        // Load saved selections from localStorage
        const saved = localStorage.getItem('selectedRows');
        if (saved) {
            selectedRows = new Set(JSON.parse(saved));
            updateUI();
        }
    });

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
        const isArchive = {{ request()->routeIs('vehicles.archived') ? 'true' : 'false' }};

        if (count > 0) {
            if (isArchive) {
                bulkRestoreBtn.style.display = 'inline-flex';
                bulkRestoreBtn.innerHTML = `<i class="fas fa-trash-restore"></i> Restore Selected (${count})`;
                bulkDeleteBtn.style.display = 'none';
            } else {
                bulkDeleteBtn.style.display = 'inline-flex';
                bulkDeleteBtn.innerHTML = `<i class="fas fa-trash"></i> Delete Selected (${count})`;
                bulkRestoreBtn.style.display = 'none';
            }
        } else {
            bulkDeleteBtn.style.display = 'none';
            bulkRestoreBtn.style.display = 'none';
        }

        // Save to localStorage
        localStorage.setItem('selectedRows', JSON.stringify([...selectedRows]));
    }

    // Bulk Action
    function bulkAction(action) {
        if (selectedRows.size === 0) return;

        const message = action === 'delete'
            ? `Archive ${selectedRows.size} selected vehicle(s)? They can be restored later.`
            : `Restore ${selectedRows.size} selected vehicle(s)?`;

        if (!confirm(message)) return;

        const form = document.getElementById('bulkActionForm');
        const ids = [...selectedRows].join(',');

        form.action = action === 'delete'
            ? '{{ route("vehicles.bulk-delete") }}'
            : '{{ route("vehicles.bulk-restore") }}';

        document.getElementById('selectedIds').value = ids;
        document.getElementById('bulkAction').value = action;

        form.submit();
    }

    // Update Status
    function updateStatus(selectElement, vehicleId) {
        const status = selectElement.value;
        const originalValue = selectElement.classList.contains('active') ? 'active' : 'inactive';
        const parkingSlotId = selectElement.dataset.parkingSlot === 'null' ? null : selectElement.dataset.parkingSlot;
        const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        // Show loading state
        selectElement.disabled = true;
        selectElement.style.opacity = '0.6';

        fetch(`/vehicles/${vehicleId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                status: status,
                parking_slot_id: parkingSlotId
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
                selectElement.className = `status-select ${status}`;

                // Update the stats counters with the new counts from server
                if (data.counts) {
                    document.getElementById('totalVehicles').textContent = data.counts.total || '{{ $totalVehicles ?? $vehicles->count() }}';
                    document.getElementById('activeCount').textContent = data.counts.active;
                    document.getElementById('inactiveCount').textContent = data.counts.inactive;
                    document.getElementById('parkingAssigned').textContent = data.counts.parking_assigned;
                }

                // Show success message
                showNotification('Status updated successfully', 'success');
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // Restore the original value
            selectElement.value = originalValue;
            selectElement.className = `status-select ${originalValue}`;

            // Show error message
            let errorMessage = 'Failed to update status';
            if (error.message) {
                errorMessage = error.message;
            } else if (typeof error === 'string') {
                errorMessage = error;
            }

            showNotification(errorMessage, 'error');
        })
        .finally(() => {
            // Remove loading state
            selectElement.disabled = false;
            selectElement.style.opacity = '1';
        });
    }

    // Preview Image
    function previewImage(src) {
        document.getElementById('modalImage').src = src;
        imageModal.show();
    }

    // Toggle Archive View
    function toggleArchive() {
        window.location.href = "{{ request()->routeIs('vehicles.archived') ? route('vehicles.index') : route('vehicles.archived') }}";
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
        const table = document.getElementById('vehiclesTable');
        const data = [];

        // Get headers
        const headers = [];
        table.querySelectorAll('thead th').forEach((th, index) => {
            if (index > 0 && index < 6) { // Skip checkbox and actions columns
                headers.push(th.textContent.trim());
            }
        });
        data.push(headers);

        // Get data
        table.querySelectorAll('tbody tr').forEach(row => {
            const rowData = [];
            const cells = row.querySelectorAll('td');

            // Vehicle Details (index 3)
            const vehicleDetails = cells[3].textContent.trim().replace(/\s+/g, ' ');

            rowData.push(cells[1].textContent.trim()); // #
            rowData.push(vehicleDetails); // Vehicle Details
            rowData.push(cells[4].textContent.trim()); // Owner
            rowData.push(cells[5].textContent.trim()); // Status

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
        XLSX.utils.book_append_sheet(wb, ws, 'Vehicles');
        XLSX.writeFile(wb, `vehicles_${new Date().toISOString().split('T')[0]}.xlsx`);
    }

    // Export to PDF
    function exportToPDF(data) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(16);
        doc.setTextColor(37, 99, 235);
        doc.text('Vehicle List', 14, 20);

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
            },
            columnStyles: {
                0: { cellWidth: 15 },
                1: { cellWidth: 50 },
                2: { cellWidth: 50 },
                3: { cellWidth: 40 }
            }
        });

        doc.save(`vehicles_${new Date().toISOString().split('T')[0]}.pdf`);
    }

    // Clear selections on page unload
    window.addEventListener('beforeunload', function() {
        localStorage.removeItem('selectedRows');
    });
</script>
@endpush
