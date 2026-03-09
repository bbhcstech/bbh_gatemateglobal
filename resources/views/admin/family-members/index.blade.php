@extends('admin.layout.app')

@section('title', 'Family Members Management')

@section('content')
<style>
    /* Professional styling */
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

    .table thead th {
        background: #f8fafc;
        color: var(--secondary);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border);
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: var(--dark);
        font-size: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:hover {
        background: #f8fafc;
    }

    .table tbody tr.own-family-member {
        background-color: rgba(16, 185, 129, 0.05);
        border-left: 3px solid var(--success);
    }

    .role-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .role-admin { background: #dbeafe; color: #1e40af; }
    .role-resident { background: #dcfce7; color: #166534; }
    .role-security { background: #fff3cd; color: #856404; }

    .search-box {
        border-radius: 10px;
        border: 1px solid var(--border);
        padding: 0.5rem 1rem;
    }

    .search-box:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
        outline: none;
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
        margin: 0 2px;
    }

    .action-btn:hover {
        background: var(--light);
        transform: translateY(-1px);
    }

    .action-btn.view:hover { border-color: var(--primary); color: var(--primary); }
    .action-btn.edit:hover { border-color: var(--warning); color: var(--warning); }
    .action-btn.delete:hover { border-color: var(--danger); color: var(--danger); }

    .action-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-light);
        color: var(--primary);
    }

    .own-family-badge {
        background: var(--success);
        color: white;
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 12px;
        margin-left: 8px;
    }

    .view-only-badge {
        background: var(--secondary);
        color: white;
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 12px;
        margin-left: 8px;
    }
</style>

<div class="container-fluid py-4">

    {{-- Role-Based Header --}}
    <div class="row mb-4">
        <div class="col-md-12">
            @php
                $role = auth()->user()->role ?? 'guest';

                $roleColors = [
                    'admin' => 'primary',
                    'resident' => 'success',
                    'security' => 'warning',
                    'guest' => 'secondary'
                ];

                $roleIcons = [
                    'admin' => 'user-shield',
                    'resident' => 'home',
                    'security' => 'shield-alt',
                    'guest' => 'user'
                ];

                $roleMessages = [
                    'admin' => 'You have full access to all residents\' family members.',
                    'resident' => 'You can view all residents but only edit your own family.',
                    'security' => 'You can only view family members (no editing).',
                    'guest' => 'Please login to access this feature.'
                ];

                $alertColor = $roleColors[$role] ?? 'secondary';
                $alertIcon = $roleIcons[$role] ?? 'info-circle';
                $alertMessage = $roleMessages[$role] ?? 'Welcome to Family Members Management.';

                // Get logged in resident's ID if they are a resident
                $loggedInResidentId = null;
                if ($role == 'resident') {
                    $loggedInResident = App\Models\Resident::where('user_id', auth()->id())->first();
                    $loggedInResidentId = $loggedInResident ? $loggedInResident->id : null;
                }
            @endphp

            <div class="alert alert-{{ $alertColor }} d-flex align-items-center shadow-sm">
                <i class="fas fa-{{ $alertIcon }} fa-2x me-3"></i>
                <div class="flex-grow-1">
                    <strong class="text-uppercase me-2">{{ ucfirst($role) }} Mode:</strong>
                    <span>{{ $alertMessage }}</span>
                </div>
                <span class="role-badge role-{{ $role }} ms-3 px-3 py-1 rounded-pill bg-white text-{{ $alertColor }}">
                    <i class="fas fa-{{ $alertIcon }} me-1"></i>
                    {{ ucfirst($role) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        @php
            $totalResidents = $residents->count();
            $totalFamilyMembers = App\Models\FamilyMember::count();
            $totalOwners = $residents->where('type', 'owner')->count();
            $totalTenants = $residents->where('type', 'tenant')->count();
        @endphp
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Residents</h6>
                            <h2 class="mt-2 mb-0">{{ $totalResidents }}</h2>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Family Members</h6>
                            <h2 class="mt-2 mb-0">{{ $totalFamilyMembers }}</h2>
                        </div>
                        <i class="fas fa-user-friends fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Owners</h6>
                            <h2 class="mt-2 mb-0">{{ $totalOwners }}</h2>
                        </div>
                        <i class="fas fa-key fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Tenants</h6>
                            <h2 class="mt-2 mb-0">{{ $totalTenants }}</h2>
                        </div>
                        <i class="fas fa-user-tie fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Header with Add Button --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users text-primary me-2"></i>
                    Family Members Directory
                </h5>
                <div>
                    @if(auth()->user()->role != 'security')
                        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'resident')
                            <a href="{{ route('family-members.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Add Family Member
                            </a>
                        @elseif(auth()->user()->role == 'resident' && $loggedInResidentId)
                            <a href="{{ route('family-members.create', ['resident_id' => $loggedInResidentId]) }}"
                               class="btn btn-success">
                                <i class="fas fa-plus me-2"></i>
                                Add Member to My Family
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        {{-- Search Section --}}
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('family-members.index') }}" class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text"
                               name="search"
                               class="form-control search-box"
                               placeholder="Search by Resident ID, Name, Flat Number, or Phone..."
                               value="{{ request('search') }}"
                               id="residentSearch">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                        @if(request('search') || request('resident_id'))
                            <a href="{{ route('family-members.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <select name="resident_id" class="form-select search-box" onchange="this.form.submit()">
                        <option value="">-- Filter by Resident --</option>
                        @foreach($residents as $resident)
                            <option value="{{ $resident->id }}"
                                {{ ($searchResidentId ?? '') == $resident->id ? 'selected' : '' }}>
                                {{ $resident->name }} - Flat {{ $resident->flat_no }} (ID: {{ $resident->id }})
                                @if($loggedInResidentId == $resident->id)
                                    (Your Family)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- Results Section --}}
    @if(isset($selectedResident) && $selectedResident)
        {{-- DETAILED VIEW: Show Selected Resident with Family Members --}}

        {{-- Resident Profile Card --}}
        <div class="card shadow-lg mb-4 border-{{ isset($isOwnFamily) && $isOwnFamily ? 'success' : 'primary' }}">
            <div class="card-header bg-{{ isset($isOwnFamily) && $isOwnFamily ? 'success' : 'primary' }} text-white py-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-circle fa-3x me-3"></i>
                    <div>
                        <h4 class="mb-1">{{ $selectedResident->name }}</h4>
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-map-marker-alt me-1"></i> Flat: {{ $selectedResident->flat_no ?? 'N/A' }}
                            @if(isset($isOwnFamily) && $isOwnFamily)
                                <span class="badge bg-light text-dark ms-2">
                                    <i class="fas fa-check-circle text-success"></i> Your Family
                                </span>
                            @else
                                <span class="badge bg-light text-dark ms-2">
                                    <i class="fas fa-eye"></i> View Only
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('family-members.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Back to Directory
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Family Members Table --}}
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-users text-primary me-2"></i>
                    Family Members of {{ $selectedResident->name }}
                    <span class="badge bg-secondary ms-2">{{ $familyMembers->count() }}</span>
                </h5>

                {{-- Add Button for this specific resident (only if admin OR it's their own family) --}}
                @if(auth()->user()->role != 'security')
                    @if(auth()->user()->role == 'admin' || (isset($isOwnFamily) && $isOwnFamily))
                        <a href="{{ route('family-members.create', ['resident_id' => $selectedResident->id]) }}"
                           class="btn btn-{{ auth()->user()->role == 'admin' ? 'primary' : 'success' }}">
                            <i class="fas fa-plus me-2"></i>
                            Add Family Member
                        </a>
                    @endif
                @endif
            </div>

            <div class="card-body">
                @if($familyMembers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Relation</th>
                                    <th>Mobile</th>
                                    <th>Added On</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($familyMembers as $index => $member)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $member->name }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark px-3 py-2">
                                                <i class="fas fa-{{ $member->relation->name == 'Father' ? 'male' : ($member->relation->name == 'Mother' ? 'female' : 'user') }} me-1"></i>
                                                {{ $member->relation->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($member->mobile)
                                                <i class="fas fa-phone-alt text-success me-1"></i>
                                                {{ $member->mobile }}
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $member->created_at ? $member->created_at->format('d M Y') : 'N/A' }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- View button always visible --}}
                                                <a href="{{ route('family-members.index', ['resident_id' => $selectedResident->id]) }}"
                                                   class="action-btn view"
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                {{-- Edit/Delete buttons based on permissions --}}
                                                @if(auth()->user()->role == 'admin')
                                                    {{-- Admin can edit/delete any --}}
                                                    <a href="{{ route('family-members.edit', $member) }}"
                                                       class="action-btn edit"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="action-btn delete"
                                                            title="Delete"
                                                            onclick="deleteMember({{ $member->member_id }}, '{{ $member->name }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @elseif(auth()->user()->role == 'resident' && isset($isOwnFamily) && $isOwnFamily)
                                                    {{-- Resident can only edit/delete their own family --}}
                                                    <a href="{{ route('family-members.edit', $member) }}"
                                                       class="action-btn edit"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="action-btn delete"
                                                            title="Delete"
                                                            onclick="deleteMember({{ $member->member_id }}, '{{ $member->name }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @elseif(auth()->user()->role == 'security')
                                                    {{-- Security view only -- already has view button --}}
                                                @else
                                                    {{-- Resident viewing other family - show disabled buttons --}}
                                                    <span class="action-btn edit disabled" title="Cannot edit others' family">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="action-btn delete disabled" title="Cannot delete others' family">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Family Summary --}}
                    <div class="alert alert-info mt-3 mb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-chart-pie me-2"></i>
                                <strong>Family Composition:</strong>
                                @php
                                    $relations = $familyMembers->groupBy('relation.name');
                                @endphp
                                @foreach($relations as $relation => $members)
                                    <span class="badge bg-light text-dark me-2">
                                        {{ $members->count() }} {{ $relation }}
                                    </span>
                                @endforeach
                            </div>
                            <div>
                                <i class="fas fa-mobile-alt me-1"></i>
                                {{ $familyMembers->whereNotNull('mobile')->count() }} have mobile
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No Family Members Found</h5>
                        <p class="text-muted mb-3">
                            @if(auth()->user()->role == 'security')
                                This resident has not added any family members yet.
                            @elseif(isset($isOwnFamily) && $isOwnFamily)
                                Start building your family profile by adding members.
                            @else
                                This resident hasn't added any family members yet.
                            @endif
                        </p>
                        @if(auth()->user()->role != 'security' && isset($isOwnFamily) && $isOwnFamily)
                            <a href="{{ route('family-members.create', ['resident_id' => $selectedResident->id]) }}"
                               class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Add Your First Family Member
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

    @else
        {{-- TABLE VIEW: Show All Family Members in Table Format --}}
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-list text-primary me-2"></i>
                    All Family Members
                </h5>
            </div>
            <div class="card-body">
                @php
                    $allFamilyMembers = App\Models\FamilyMember::with(['resident', 'relation'])->latest()->get();
                @endphp

                @if($allFamilyMembers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="familyMembersTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Member Name</th>
                                    <th>Relation</th>
                                    <th>Mobile</th>
                                    <th>Resident</th>
                                    <th>Flat No.</th>
                                    <th>Added On</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allFamilyMembers as $index => $member)
                                    @php
                                        $isOwnFamily = ($loggedInResidentId && $loggedInResidentId == $member->resident_id);
                                    @endphp
                                    <tr class="{{ $isOwnFamily ? 'own-family-member' : '' }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $member->name }}</strong>
                                                    @if($isOwnFamily)
                                                        <span class="own-family-badge">Your Family</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark px-3 py-2">
                                                {{ $member->relation->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($member->mobile)
                                                <i class="fas fa-phone-alt text-success me-1"></i>
                                                {{ $member->mobile }}
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('family-members.index', ['resident_id' => $member->resident_id]) }}"
                                               class="text-primary text-decoration-none">
                                                {{ $member->resident->name ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>{{ $member->resident->flat_no ?? 'N/A' }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $member->created_at ? $member->created_at->format('d M Y') : 'N/A' }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- View Resident button --}}
                                                <a href="{{ route('family-members.index', ['resident_id' => $member->resident_id]) }}"
                                                   class="action-btn view"
                                                   title="View Resident">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                {{-- Role-based actions --}}
                                                @if(auth()->user()->role == 'admin')
                                                    {{-- Admin: full access --}}
                                                    <a href="{{ route('family-members.edit', $member) }}"
                                                       class="action-btn edit"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="action-btn delete"
                                                            title="Delete"
                                                            onclick="deleteMember({{ $member->member_id }}, '{{ $member->name }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>

                                                @elseif(auth()->user()->role == 'resident')
                                                    {{-- Resident: only edit/delete their own --}}
                                                    @if($isOwnFamily)
                                                        <a href="{{ route('family-members.edit', $member) }}"
                                                           class="action-btn edit"
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button"
                                                                class="action-btn delete"
                                                                title="Delete"
                                                                onclick="deleteMember({{ $member->member_id }}, '{{ $member->name }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <span class="action-btn edit disabled" title="Cannot edit others' family">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                        <span class="action-btn delete disabled" title="Cannot delete others' family">
                                                            <i class="fas fa-trash"></i>
                                                        </span>
                                                    @endif

                                                @elseif(auth()->user()->role == 'security')
                                                    {{-- Security: view only --}}
                                                    <span class="action-btn view" title="View Only">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                    <span class="action-btn edit disabled" title="View Only">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="action-btn delete disabled" title="View Only">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No Family Members Found</h5>
                        <p class="text-muted">Get started by adding your first family member.</p>
                        @if(auth()->user()->role != 'security')
                            @if(auth()->user()->role == 'admin')
                                <a href="{{ route('family-members.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Add First Family Member
                                </a>
                            @elseif(auth()->user()->role == 'resident' && $loggedInResidentId)
                                <a href="{{ route('family-members.create', ['resident_id' => $loggedInResidentId]) }}"
                                   class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i>
                                    Add Your First Family Member
                                </a>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Quick Access Modal --}}
    @if(auth()->user()->role != 'security')
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 100;">
        <button type="button" class="btn btn-primary rounded-circle shadow-lg"
                data-bs-toggle="modal" data-bs-target="#quickAccessModal"
                style="width: 60px; height: 60px;">
            <i class="fas fa-bolt fa-2x"></i>
        </button>
    </div>

    <!-- Quick Access Modal -->
    <div class="modal fade" id="quickAccessModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-bolt text-primary me-2"></i>
                        Quick Access
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">Enter Resident ID to view their family members</p>
                    <div class="input-group">
                        <input type="number" id="quickResidentId" class="form-control"
                               placeholder="Enter Resident ID (e.g., 1, 2, 3...)" min="1">
                        <button class="btn btn-primary" onclick="quickAccess()">
                            <i class="fas fa-arrow-right me-2"></i>Go
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Delete Form (Hidden) --}}
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Auto-submit on enter
document.getElementById('residentSearch')?.addEventListener('keypress', function(e) {
    if(e.key === 'Enter') {
        e.preventDefault();
        this.form.submit();
    }
});

// Quick access function
function quickAccess() {
    const id = document.getElementById('quickResidentId').value;
    if(id) {
        window.location.href = "{{ route('family-members.index') }}?resident_id=" + id;
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Please enter a Resident ID'
        });
    }
}

// Delete confirmation
function deleteMember(id, name) {
    Swal.fire({
        title: 'Are you sure?',
        text: `You are about to delete ${name}. This action cannot be undone!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `{{ url('family-members') }}/${id}`;
            form.submit();
        }
    });
}

// Show success message from session
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif
</script>
@endpush

@endsection
