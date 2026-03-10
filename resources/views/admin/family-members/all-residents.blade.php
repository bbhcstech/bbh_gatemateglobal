@extends('admin.layout.app')

@section('title', 'All Residents\' Family Members')

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
        background: #2563eb;
        color: white;
        padding: 0.35rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
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
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        border-color: #2563eb;
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

    .stat-icon.total { background: #dbeafe; color: #2563eb; }
    .stat-icon.relations { background: #fed7aa; color: #f59e0b; }
    .stat-icon.active { background: #d1fae5; color: #10b981; }
    .stat-icon.mobile { background: #e2e8f0; color: #64748b; }

    .stat-info h6 {
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 0.25rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .stat-info h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        line-height: 1.2;
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
        color: #64748b;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e2e8f0;
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
        color: #1e293b;
        font-size: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    /* Member Avatar */
    .member-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 1.2rem;
        border: 2px solid #e2e8f0;
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

    /* Resident Badge */
    .resident-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        background: #f8fafc;
        border-radius: 6px;
        font-size: 0.7rem;
        color: #64748b;
        margin-top: 0.25rem;
    }

    .resident-badge i {
        color: #2563eb;
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
</style>

@php
$totalFamilyMembers = $familyMembers->count();
$totalResidents = $familyMembers->groupBy('resident_id')->count();
$totalRelations = $familyMembers->groupBy('relation_id')->count();
$withMobile = $familyMembers->whereNotNull('mobile')->count();
@endphp

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="header-title">
            <h2>
                <i class="fas fa-users me-2" style="color: #2563eb;"></i>
                All Residents' Family Members
            </h2>
            <p>View all family members from every resident in the society</p>
        </div>
        <div>
            <a href="{{ route('family-members.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to My Family
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h6>Total Family Members</h6>
                <h3>{{ $totalFamilyMembers }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon active">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-info">
                <h6>Total Residents</h6>
                <h3>{{ $totalResidents }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon relations">
                <i class="fas fa-heart"></i>
            </div>
            <div class="stat-info">
                <h6>Relations Types</h6>
                <h3>{{ $totalRelations }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon mobile">
                <i class="fas fa-phone-alt"></i>
            </div>
            <div class="stat-info">
                <h6>Has Mobile</h6>
                <h3>{{ $withMobile }}</h3>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-list"></i>
                Complete Family Directory
            </h5>
            <span class="total-badge">
                <i class="fas fa-users me-2"></i>
                Total: {{ $totalFamilyMembers }} Members
            </span>
        </div>

        <div class="table-responsive">
            @if($familyMembers->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h6>No family members found in the society</h6>
                </div>
            @else
                <table class="family-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Relation</th>
                            <th>Contact</th>
                            <th>Resident</th>
                            <th>Flat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($familyMembers as $key => $member)
                            @php
                                $relationClass = strtolower($member->relation->name ?? 'other');
                                $relationIcon = match($relationClass) {
                                    'father' => 'fa-male',
                                    'mother' => 'fa-female',
                                    'son' => 'fa-male',
                                    'daughter' => 'fa-female',
                                    'spouse' => 'fa-heart',
                                    default => 'fa-user'
                                };
                            @endphp
                            <tr>
                                <td>
                                    <span style="color: #64748b;">{{ $key + 1 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="member-avatar me-2">
                                            <i class="fas {{ $relationIcon }}"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 600;">
                                                {{ $member->name ?? '-' }}
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
                                    <a href="{{ route('family-members.show', $member->member_id) }}" class="btn-view">
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

@endsection

@push('scripts')
<script>
    // Show any success/error messages from session
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
