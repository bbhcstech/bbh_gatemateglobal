@extends('admin.layout.app')

@section('title', 'Vehicle Management')

@section('content')
<style>
    /* Purple & White Theme - Enhanced */
    :root {
        --primary-purple: #8B5CF6;
        --primary-purple-dark: #7C3AED;
        --primary-purple-light: #EDE9FE;
        --secondary-purple: #A78BFA;
        --gradient-purple: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
        --gradient-purple-hover: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);
    }

    /* Header Styling - Enhanced */
    .page-header {
        background: var(--gradient-purple);
        padding: 30px 35px;
        border-radius: 25px;
        margin-bottom: 30px;
        color: white;
        box-shadow: 0 20px 40px rgba(124, 58, 237, 0.3);
        animation: slideDown 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Stats Cards - Enhanced */
    .stats-card {
        background: white;
        border-radius: 20px;
        padding: 25px 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.03);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid var(--primary-purple-light);
        animation: fadeInUp 0.6s ease-out;
        position: relative;
        overflow: hidden;
    }

    .stats-card::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: var(--primary-purple-light);
        border-radius: 50%;
        opacity: 0.3;
        transform: translate(30px, -30px);
        transition: all 0.4s ease;
    }

    .stats-card:hover::after {
        transform: translate(20px, -20px) scale(1.5);
        opacity: 0.5;
    }

    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(124, 58, 237, 0.2);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-purple-light);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-purple);
        font-size: 1.8rem;
        transition: all 0.4s ease;
        position: relative;
        z-index: 1;
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.1) rotate(5deg);
        background: var(--primary-purple);
        color: white;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Main Card - Enhanced */
    .main-card {
        border: none;
        border-radius: 25px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        animation: fadeInUp 0.8s ease-out;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }

    .card-header-custom {
        background: white;
        padding: 22px 30px;
        border-bottom: 3px solid var(--primary-purple);
        position: relative;
    }

    .card-header-custom::before {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 100px;
        height: 3px;
        background: var(--gradient-purple);
        animation: slide 2s infinite;
    }

    @keyframes slide {
        0% { left: 0; width: 100px; }
        50% { left: 50%; width: 200px; transform: translateX(-50%); }
        100% { left: calc(100% - 100px); width: 100px; }
    }

    .card-header-custom h5 {
        background: var(--gradient-purple);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 700;
        margin: 0;
        font-size: 1.3rem;
        letter-spacing: 0.5px;
    }

    /* Table Styling - Enhanced */
    .vehicle-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .vehicle-table thead th {
        background: linear-gradient(135deg, #F9FAFB 0%, #F3F4F6 100%);
        color: #4B5563;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 18px 15px;
        border: none;
        position: relative;
    }

    .vehicle-table thead th:first-child {
        border-radius: 15px 0 0 15px;
    }

    .vehicle-table thead th:last-child {
        border-radius: 0 15px 15px 0;
    }

    .vehicle-table tbody tr {
        background: white;
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        position: relative;
        animation: fadeInRow 0.5s ease-out forwards;
        opacity: 0;
    }

    /* Individual row animations */
    .vehicle-table tbody tr:nth-child(1) { animation-delay: 0.05s; }
    .vehicle-table tbody tr:nth-child(2) { animation-delay: 0.10s; }
    .vehicle-table tbody tr:nth-child(3) { animation-delay: 0.15s; }
    .vehicle-table tbody tr:nth-child(4) { animation-delay: 0.20s; }
    .vehicle-table tbody tr:nth-child(5) { animation-delay: 0.25s; }
    .vehicle-table tbody tr:nth-child(6) { animation-delay: 0.30s; }
    .vehicle-table tbody tr:nth-child(7) { animation-delay: 0.35s; }
    .vehicle-table tbody tr:nth-child(8) { animation-delay: 0.40s; }
    .vehicle-table tbody tr:nth-child(9) { animation-delay: 0.45s; }
    .vehicle-table tbody tr:nth-child(10) { animation-delay: 0.50s; }
    .vehicle-table tbody tr:nth-child(11) { animation-delay: 0.55s; }
    .vehicle-table tbody tr:nth-child(12) { animation-delay: 0.60s; }
    .vehicle-table tbody tr:nth-child(13) { animation-delay: 0.65s; }
    .vehicle-table tbody tr:nth-child(14) { animation-delay: 0.70s; }
    .vehicle-table tbody tr:nth-child(15) { animation-delay: 0.75s; }
    .vehicle-table tbody tr:nth-child(16) { animation-delay: 0.80s; }
    .vehicle-table tbody tr:nth-child(17) { animation-delay: 0.85s; }
    .vehicle-table tbody tr:nth-child(18) { animation-delay: 0.90s; }
    .vehicle-table tbody tr:nth-child(19) { animation-delay: 0.95s; }
    .vehicle-table tbody tr:nth-child(20) { animation-delay: 1.00s; }

    @keyframes fadeInRow {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .vehicle-table tbody tr:hover {
        transform: translateX(8px) scale(1.01);
        box-shadow: 0 15px 35px rgba(124, 58, 237, 0.15);
        background: linear-gradient(135deg, white, var(--primary-purple-light));
    }

    .vehicle-table tbody td {
        padding: 18px 15px;
        vertical-align: middle;
        border: none;
    }

    /* Vehicle Image - Enhanced */
    .vehicle-image-wrapper {
        width: 55px;
        height: 55px;
        border-radius: 18px;
        overflow: hidden;
        cursor: pointer;
        border: 3px solid transparent;
        background: var(--gradient-purple);
        padding: 3px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 5px 15px rgba(124, 58, 237, 0.2);
    }

    .vehicle-image-wrapper:hover {
        transform: scale(1.15) rotate(3deg);
        box-shadow: 0 15px 30px rgba(124, 58, 237, 0.4);
    }

    .vehicle-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 15px;
    }

    /* Status Badges - Enhanced */
    .status-badge {
        padding: 8px 18px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .status-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .status-badge:hover::before {
        left: 100%;
    }

    .status-badge i {
        font-size: 0.9rem;
    }

    .status-approved {
        background: linear-gradient(135deg, #DEF7EC 0%, #BCF0DA 100%);
        color: #0E9F6E;
        box-shadow: 0 4px 12px rgba(14, 159, 110, 0.2);
    }

    .status-pending {
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
        color: #B45309;
        box-shadow: 0 4px 12px rgba(180, 83, 9, 0.2);
    }

    .status-rejected {
        background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
        color: #DC2626;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
    }

    .status-inactive {
        background: linear-gradient(135deg, #E5E7EB 0%, #D1D5DB 100%);
        color: #4B5563;
        box-shadow: 0 4px 12px rgba(75, 85, 99, 0.2);
    }

    .status-blacklisted {
        background: linear-gradient(135deg, #1F2937 0%, #111827 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    /* Action Buttons - Enhanced */
    .action-group {
        display: flex;
        gap: 8px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .action-btn {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        border: none;
        background: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        position: relative;
        overflow: hidden;
        font-size: 1.1rem;
    }

    .action-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .action-btn:hover::before {
        width: 100px;
        height: 100px;
    }

    .action-btn.view {
        color: var(--primary-purple);
        border: 1px solid var(--primary-purple-light);
    }

    .action-btn.view:hover {
        background: var(--primary-purple);
        color: white;
        transform: translateY(-5px) rotate(5deg);
        box-shadow: 0 10px 20px rgba(124, 58, 237, 0.4);
    }

    .action-btn.edit {
        color: #F59E0B;
        border: 1px solid #FEF3C7;
    }

    .action-btn.edit:hover {
        background: #F59E0B;
        color: white;
        transform: translateY(-5px) rotate(5deg);
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.4);
    }

    .action-btn.delete {
        color: #EF4444;
        border: 1px solid #FEE2E2;
    }

    .action-btn.delete:hover {
        background: #EF4444;
        color: white;
        transform: translateY(-5px) rotate(5deg);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.4);
    }

    .action-btn.restore {
        color: #10B981;
        border: 1px solid #DEF7EC;
    }

    .action-btn.restore:hover {
        background: #10B981;
        color: white;
        transform: translateY(-5px) rotate(5deg);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.4);
    }

    .action-btn.status {
        color: var(--primary-purple);
        border: 1px solid var(--primary-purple-light);
    }

    .action-btn.status:hover {
        background: var(--primary-purple);
        color: white;
        transform: translateY(-5px) rotate(5deg);
        box-shadow: 0 10px 20px rgba(124, 58, 237, 0.4);
    }

    /* Status Dropdown Menu - New */
    .status-dropdown-menu {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(124, 58, 237, 0.2);
        padding: 10px;
        min-width: 180px;
        animation: fadeInScale 0.3s ease-out;
        border: 1px solid var(--primary-purple-light);
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .status-dropdown-item {
        border-radius: 12px;
        padding: 10px 15px;
        margin: 5px 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }

    .status-dropdown-item:hover {
        background: var(--primary-purple-light);
        transform: translateX(5px);
    }

    .status-dropdown-item.active {
        background: var(--primary-purple-light);
        color: var(--primary-purple);
        font-weight: 600;
    }

    .status-dropdown-item i {
        width: 20px;
        text-align: center;
    }

    /* Archive Toggle - Enhanced */
    .archive-toggle {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 40px;
        padding: 10px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.4s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .archive-toggle::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .archive-toggle:hover::before {
        left: 100%;
    }

    .archive-toggle.active {
        background: white;
        color: var(--primary-purple);
        border-color: white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .archive-toggle:hover {
        background: white;
        color: var(--primary-purple);
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    /* Add Vehicle Button - Enhanced */
    .add-vehicle-btn {
        background: white;
        color: var(--primary-purple);
        border-radius: 40px;
        padding: 10px 30px;
        font-weight: 600;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        transition: all 0.4s ease;
        border: none;
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .add-vehicle-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(124, 58, 237, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .add-vehicle-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .add-vehicle-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.3);
        background: var(--primary-purple);
        color: white;
    }

    /* Empty State - Enhanced */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: linear-gradient(135deg, #F9FAFB 0%, #F3F4F6 100%);
        border-radius: 30px;
        margin: 20px;
    }

    .empty-state-icon {
        font-size: 5rem;
        color: var(--primary-purple-light);
        margin-bottom: 25px;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .empty-state h6 {
        color: #4B5563;
        font-size: 1.3rem;
        margin-bottom: 25px;
        font-weight: 500;
    }

    /* Modal - Enhanced */
    .modal-content {
        border-radius: 25px;
        overflow: hidden;
        border: none;
        box-shadow: 0 30px 60px rgba(124, 58, 237, 0.3);
    }

    .modal-header {
        background: var(--gradient-purple);
        color: white;
        border: none;
        padding: 20px 25px;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .modal-header .btn-close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 25px;
    }

    /* DataTables Customization */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid var(--primary-purple-light);
        border-radius: 15px;
        padding: 8px 15px;
        transition: all 0.3s ease;
    }

    .dataTables_wrapper .dataTables_length select:focus,
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--primary-purple);
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
        outline: none;
    }

    .dataTables_paginate .paginate_button {
        border-radius: 12px !important;
        margin: 0 3px;
        transition: all 0.3s ease;
        border: 1px solid var(--primary-purple-light) !important;
    }

    .dataTables_paginate .paginate_button.current {
        background: var(--gradient-purple) !important;
        border: none !important;
        color: white !important;
        box-shadow: 0 5px 15px rgba(124, 58, 237, 0.3);
    }

    .dataTables_paginate .paginate_button:hover {
        background: var(--primary-purple-light) !important;
        border-color: var(--primary-purple) !important;
        transform: translateY(-2px);
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-2">🚘 Vehicle Management</h2>
            <p class="mb-0 opacity-75">Manage all resident vehicles and parking assignments</p>
        </div>

        <div class="d-flex gap-3">
            <!-- Archive Toggle Button -->
            <button class="archive-toggle {{ request()->routeIs('vehicles.archived') ? 'active' : '' }}"
                    onclick="toggleArchive()">
                <i class="fas fa-{{ request()->routeIs('vehicles.archived') ? 'eye' : 'archive' }}"></i>
                <span>{{ request()->routeIs('vehicles.archived') ? 'Show Active' : 'Show Archived' }}</span>
            </button>

            @if(auth()->check() && in_array(strtolower(optional(auth()->user()->roleMaster)->role_name), ['admin', 'resident']))
                <a href="{{ route('vehicles.create') }}" class="add-vehicle-btn">
                    <i class="fas fa-plus-circle"></i>
                    Add Vehicle
                </a>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4 g-4">
        <div class="col-md-3">
            <div class="stats-card d-flex align-items-center">
                <div class="stats-icon me-3">
                    <i class="fas fa-car"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Total Vehicles</h6>
                    <h3 class="fw-bold mb-0" style="color: var(--primary-purple);">{{ $totalVehicles ?? $vehicles->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card d-flex align-items-center">
                <div class="stats-icon me-3" style="background: #DEF7EC; color: #0E9F6E;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Approved</h6>
                    <h3 class="fw-bold mb-0 text-success">{{ $approvedCount ?? $vehicles->where('status', 'approved')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card d-flex align-items-center">
                <div class="stats-icon me-3" style="background: #FEF3C7; color: #B45309;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Pending</h6>
                    <h3 class="fw-bold mb-0 text-warning">{{ $pendingCount ?? $vehicles->where('status', 'pending')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card d-flex align-items-center">
                <div class="stats-icon me-3" style="background: #E5E7EB; color: #4B5563;">
                    <i class="fas fa-parking"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Parking Assigned</h6>
                    <h3 class="fw-bold mb-0" style="color: #4B5563;">{{ $parkingAssigned ?? $vehicles->whereNotNull('parking_slot_id')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <h5>
                <i class="fas fa-{{ request()->routeIs('vehicles.archived') ? 'archive' : 'list' }} me-2"></i>
                {{ request()->routeIs('vehicles.archived') ? 'Archived Vehicles' : 'Active Vehicles' }}
            </h5>
            <div>
                <span class="badge" style="background: var(--primary-purple-light); color: var(--primary-purple); padding: 8px 18px; border-radius: 30px; font-weight: 600;">
                    <i class="fas fa-{{ request()->routeIs('vehicles.archived') ? 'archive' : 'check-circle' }} me-1"></i>
                    {{ $vehicles->count() }} {{ Str::plural('Record', $vehicles->count()) }}
                </span>
            </div>
        </div>

        <div class="card-body p-4">
            @if($vehicles->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h6>No vehicles found</h6>
                    @if(auth()->check() && in_array(strtolower(optional(auth()->user()->roleMaster)->role_name), ['admin', 'resident']))
                        <a href="{{ route('vehicles.create') }}" class="btn" style="background: var(--primary-purple); color: white; border-radius: 40px; padding: 12px 35px; font-weight: 600; box-shadow: 0 10px 25px rgba(124, 58, 237, 0.3);">
                            <i class="fas fa-plus-circle me-2"></i>
                            Add Your First Vehicle
                        </a>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table id="vehiclesTable" class="vehicle-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Vehicle Number</th>
                                <th>Owner</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicles as $key => $vehicle)
                                <tr>
                                    <td>
                                        <span class="fw-bold" style="color: var(--primary-purple);">{{ $key + 1 }}</span>
                                    </td>

                                    <!-- Vehicle Image -->
                                    <td>
                                        @if($vehicle->vehicle_image)
                                            <div class="vehicle-image-wrapper" onclick="previewImage('{{ asset($vehicle->vehicle_image) }}')">
                                                <img src="{{ asset($vehicle->vehicle_image) }}" alt="Vehicle">
                                            </div>
                                        @else
                                            <div class="vehicle-image-wrapper" onclick="previewImage('{{ asset('default-vehicle.png') }}')" style="background: var(--primary-purple-light); display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-car" style="color: var(--primary-purple); font-size: 1.5rem;"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Vehicle Number -->
                                    <td>
                                        <div>
                                            <span class="fw-bold" style="font-size: 1.1rem;">{{ $vehicle->vehicle_number ?? '-' }}</span>
                                            <br>
                                            <small class="text-muted">{{ $vehicle->vehicle_type ?? 'N/A' }}</small>
                                        </div>
                                    </td>

                                    <!-- Owner -->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div style="width: 40px; height: 40px; background: var(--primary-purple-light); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                                <i class="fas fa-user" style="color: var(--primary-purple);"></i>
                                            </div>
                                            <div>
                                                <span class="fw-bold">{{ $vehicle->resident->name ?? $vehicle->owner_name ?? 'N/A' }}</span>
                                                @if($vehicle->resident && $vehicle->resident->flat)
                                                    <br>
                                                    <small class="text-muted"><i class="fas fa-home me-1"></i>Flat: {{ $vehicle->resident->flat->flat_no ?? 'N/A' }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Status - Dynamically from DB -->
                                    <td>
                                        @php
                                            $status = $vehicle->status ?? 'pending';
                                            $statusClass = match($status) {
                                                'approved' => 'status-approved',
                                                'pending' => 'status-pending',
                                                'rejected' => 'status-rejected',
                                                'inactive' => 'status-inactive',
                                                'blacklisted' => 'status-blacklisted',
                                                default => 'status-pending'
                                            };
                                            $statusIcon = match($status) {
                                                'approved' => 'fa-check-circle',
                                                'pending' => 'fa-clock',
                                                'rejected' => 'fa-times-circle',
                                                'inactive' => 'fa-circle',
                                                'blacklisted' => 'fa-ban',
                                                default => 'fa-question-circle'
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            <i class="fas {{ $statusIcon }}"></i>
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-center">
                                        <div class="action-group">
                                            <!-- View -->
                                            <a href="{{ route('vehicles.show', $vehicle->id) }}"
                                               class="action-btn view"
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Edit (only for active vehicles) -->
                                            @if(!$vehicle->trashed())
                                                <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                                   class="action-btn edit"
                                                   title="Edit Vehicle">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            <!-- Status Change Dropdown (Admin Only) -->
                                            @if(auth()->user()->role === 'admin' && !$vehicle->trashed())
                                                <div class="dropdown">
                                                    <button class="action-btn status dropdown-toggle"
                                                            type="button"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false"
                                                            title="Change Status">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </button>
                                                    <ul class="dropdown-menu status-dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <form action="{{ route('vehicles.status', $vehicle->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="approved">
                                                                <button type="submit" class="dropdown-item status-dropdown-item {{ $vehicle->status == 'approved' ? 'active' : '' }}">
                                                                    <i class="fas fa-check-circle text-success"></i>
                                                                    <span>Approve</span>
                                                                    @if($vehicle->status == 'approved')
                                                                        <i class="fas fa-check ms-auto"></i>
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('vehicles.status', $vehicle->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="pending">
                                                                <button type="submit" class="dropdown-item status-dropdown-item {{ $vehicle->status == 'pending' ? 'active' : '' }}">
                                                                    <i class="fas fa-clock text-warning"></i>
                                                                    <span>Pending</span>
                                                                    @if($vehicle->status == 'pending')
                                                                        <i class="fas fa-check ms-auto"></i>
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('vehicles.status', $vehicle->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="rejected">
                                                                <button type="submit" class="dropdown-item status-dropdown-item {{ $vehicle->status == 'rejected' ? 'active' : '' }}">
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                    <span>Reject</span>
                                                                    @if($vehicle->status == 'rejected')
                                                                        <i class="fas fa-check ms-auto"></i>
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form action="{{ route('vehicles.status', $vehicle->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="inactive">
                                                                <button type="submit" class="dropdown-item status-dropdown-item {{ $vehicle->status == 'inactive' ? 'active' : '' }}">
                                                                    <i class="fas fa-circle text-secondary"></i>
                                                                    <span>Inactive</span>
                                                                    @if($vehicle->status == 'inactive')
                                                                        <i class="fas fa-check ms-auto"></i>
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('vehicles.status', $vehicle->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="blacklisted">
                                                                <button type="submit" class="dropdown-item status-dropdown-item {{ $vehicle->status == 'blacklisted' ? 'active' : '' }}">
                                                                    <i class="fas fa-ban text-dark"></i>
                                                                    <span>Blacklist</span>
                                                                    @if($vehicle->status == 'blacklisted')
                                                                        <i class="fas fa-check ms-auto"></i>
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif

                                            <!-- Restore (only for archived) -->
                                            @if($vehicle->trashed())
                                                <form action="{{ route('vehicles.restore', $vehicle->id) }}"
                                                      method="POST"
                                                      class="d-inline restore-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                            class="action-btn restore"
                                                            title="Restore Vehicle"
                                                            onclick="return confirm('Restore this vehicle?')">
                                                        <i class="fas fa-trash-restore"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Delete (Soft Delete) -->
                                            @if(auth()->user()->role === 'admin' || $vehicle->user_id === auth()->id())
                                                @if(!$vehicle->trashed())
                                                    <form action="{{ route('vehicles.destroy', $vehicle->id) }}"
                                                          method="POST"
                                                          class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="action-btn delete"
                                                                title="Archive Vehicle"
                                                                onclick="return confirm('Are you sure you want to archive this vehicle? It can be restored later.')">
                                                            <i class="fas fa-archive"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    @if(auth()->user()->role === 'admin')
                                                        <!-- Permanent Delete (Admin Only) -->
                                                        <form action="{{ route('vehicles.force-delete', $vehicle->id) }}"
                                                              method="POST"
                                                              class="d-inline force-delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="action-btn delete"
                                                                    title="Permanently Delete"
                                                                    style="background: #FEE2E2; color: #DC2626;"
                                                                    onclick="return confirm('WARNING: This will permanently delete the vehicle. This action cannot be undone!')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-image me-2"></i>Vehicle Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <img id="previewImg" class="img-fluid rounded" style="max-height: 300px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- Bootstrap Bundle (for dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        $('#vehiclesTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[0, 'asc']],
            language: {
                search: "<i class='fas fa-search'></i> Search:",
                searchPlaceholder: "Search vehicles...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ vehicles",
                infoEmpty: "Showing 0 to 0 of 0 vehicles",
                infoFiltered: "(filtered from _MAX_ total vehicles)",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>'
                }
            },
            drawCallback: function() {
                // Reinitialize dropdowns after table redraw
                var dropdowns = document.querySelectorAll('.dropdown-toggle');
                dropdowns.forEach(function(dropdown) {
                    new bootstrap.Dropdown(dropdown);
                });
            }
        });

        // Initialize dropdowns
        var dropdowns = document.querySelectorAll('.dropdown-toggle');
        dropdowns.forEach(function(dropdown) {
            new bootstrap.Dropdown(dropdown);
        });
    });

    function previewImage(src) {
        document.getElementById('previewImg').src = src;
        new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
    }

    function toggleArchive() {
        window.location.href = "{{ request()->routeIs('vehicles.archived') ? route('vehicles.index') : route('vehicles.archived') }}";
    }

    // Add loading effect on form submit
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                btn.disabled = true;
            }
        });
    });
</script>
@endpush
