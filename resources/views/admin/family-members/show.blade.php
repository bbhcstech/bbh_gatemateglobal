@extends('admin.layout.app')

@section('title', 'View Family Member Details')

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
        border-bottom: 2px solid #f59e0b;
        padding: 16px 20px;
        border-radius: 12px 12px 0 0 !important;
    }

    .detail-card .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #f59e0b;
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
        display: flex;
        align-items: center;
        gap: 4px;
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

    .avatar-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        border: 4px solid white;
        box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.3);
    }

    .avatar-large i {
        font-size: 3.5rem;
        color: white;
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
        background: #d1fae5;
        color: #059669;
    }

    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    .relation-badge-large {
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .relation-father {
        background: #dbeafe;
        color: #1e40af;
    }

    .relation-mother {
        background: #fce7f3;
        color: #9d174d;
    }

    .relation-son {
        background: #d1fae5;
        color: #065f46;
    }

    .relation-daughter {
        background: #fed7aa;
        color: #92400e;
    }

    .relation-spouse {
        background: #e2e8f0;
        color: #334155;
    }

    .relation-other {
        background: #f1f5f9;
        color: #475569;
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
        color: #f59e0b;
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

    .btn-view-resident {
        background: #2563eb;
        color: white;
    }

    .btn-view-resident:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
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

    .btn-danger-badge {
        background: #ef4444;
        color: white;
        border: none;
    }

    .btn-danger-badge:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        color: white;
    }

    .btn-restore {
        background: #10b981;
        color: white;
        border: none;
    }

    .btn-restore:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: white;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .info-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    @media (max-width: 768px) {
        .info-grid, .info-grid-3 {
            grid-template-columns: 1fr;
        }
    }

    .mobile-badge {
        background: #f3e8ff;
        color: #6b21a8;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .audit-trail-item {
        background: #f8fafc;
        border-radius: 8px;
        padding: 12px;
        border-left: 3px solid #f59e0b;
    }

    .audit-label {
        font-size: 0.7rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .audit-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
    }
</style>

<div class="container-fluid py-4">
    <!-- Back Link -->
    <a href="{{ route('family-members.index', ['resident_id' => $familyMember->resident_id]) }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
        Back to Family Members
    </a>

    <div class="row g-4">
        <!-- LEFT COLUMN - Member Details -->
        <div class="col-lg-8">
            <div class="detail-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-user"></i>
                        Family Member Details
                        @if($familyMember->trashed())
                            <span class="status-badge status-inactive ms-3">
                                <i class="fas fa-archive"></i>
                                Archived
                            </span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Avatar and Relation Badge -->
                    @php
                        $relationName = $familyMember->relation->name ?? 'Other';
                        $relationClass = strtolower($relationName);
                        $relationIcon = match(true) {
                            in_array($relationName, ['Father', 'Son', 'Brother', 'Grandfather']) => 'fa-male',
                            in_array($relationName, ['Mother', 'Daughter', 'Sister', 'Grandmother']) => 'fa-female',
                            $relationName == 'Spouse' => 'fa-heart',
                            default => 'fa-user'
                        };

                        $relationColorClass = match(true) {
                            in_array($relationName, ['Father', 'Grandfather']) => 'relation-father',
                            in_array($relationName, ['Mother', 'Grandmother']) => 'relation-mother',
                            in_array($relationName, ['Son', 'Brother']) => 'relation-son',
                            in_array($relationName, ['Daughter', 'Sister']) => 'relation-daughter',
                            $relationName == 'Spouse' => 'relation-spouse',
                            default => 'relation-other'
                        };
                    @endphp

                    <div class="text-center mb-4">
                        <div class="avatar-large">
                            <i class="fas {{ $relationIcon }}"></i>
                        </div>
                        <h3 class="mb-2">{{ $familyMember->name }}</h3>
                        <span class="relation-badge-large {{ $relationColorClass }}">
                            <i class="fas {{ $relationIcon }}"></i>
                            {{ $relationName }}
                        </span>

                        @if($familyMember->activity_status)
                            <span class="status-badge status-active ms-2">
                                <i class="fas fa-check-circle"></i>
                                Active
                            </span>
                        @else
                            <span class="status-badge status-inactive ms-2">
                                <i class="fas fa-times-circle"></i>
                                Inactive
                            </span>
                        @endif
                    </div>

                    <div class="info-grid">
                        <!-- Full Name -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-tag" style="color: #f59e0b;"></i>
                                Full Name
                            </div>
                            <div class="info-value">{{ $familyMember->name ?? '-' }}</div>
                        </div>

                        <!-- Relationship -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-heart" style="color: #f59e0b;"></i>
                                Relationship
                            </div>
                            <div class="info-value">{{ $familyMember->relation->name ?? 'N/A' }}</div>
                        </div>

                        <!-- Mobile Number -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-phone-alt" style="color: #f59e0b;"></i>
                                Mobile Number
                            </div>
                            <div class="info-value">
                                @if($familyMember->mobile)
                                    <span class="mobile-badge">
                                        <i class="fas fa-phone-alt"></i>
                                        {{ $familyMember->mobile }}
                                    </span>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </div>
                        </div>

                        <!-- Member ID -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-id-card" style="color: #f59e0b;"></i>
                                Member ID
                            </div>
                            <div class="info-value">#{{ $familyMember->member_id }}</div>
                        </div>
                    </div>

                    <!-- Resident Information -->
                    <div class="mt-4">
                        <div class="info-label">
                            <i class="fas fa-home" style="color: #f59e0b;"></i>
                            Resident Information
                        </div>
                        <div class="info-value">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Name:</strong> {{ $familyMember->resident->name ?? '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Flat:</strong> {{ $familyMember->resident->flat_no ?? 'N/A' }}
                                </div>
                                @if($familyMember->resident)
                                <div class="col-md-6 mt-2">
                                    <strong>Contact:</strong> {{ $familyMember->resident->phone ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mt-2">
                                    <strong>Email:</strong> {{ $familyMember->resident->email ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mt-2">
                                    <strong>Resident Type:</strong> {{ ucfirst($familyMember->resident->type ?? 'N/A') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Registration Information -->
                    <div class="mt-4">
                        <div class="info-label">
                            <i class="fas fa-calendar" style="color: #f59e0b;"></i>
                            Registration Information
                        </div>
                        <div class="info-value">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Added on:</strong> {{ $familyMember->created_at ? $familyMember->created_at->format('d M Y, h:i A') : '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Last Updated:</strong> {{ $familyMember->updated_at ? $familyMember->updated_at->format('d M Y, h:i A') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deletion Information (if archived) -->
                    @if($familyMember->trashed())
                    <div class="mt-4">
                        <div class="info-label">
                            <i class="fas fa-archive" style="color: #dc2626;"></i>
                            Archival Information
                        </div>
                        <div class="info-value">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Archived on:</strong> {{ $familyMember->deleted_at ? $familyMember->deleted_at->format('d M Y, h:i A') : '-' }}
                                </div>
                                @if($familyMember->deleter)
                                <div class="col-md-6">
                                    <strong>Archived by:</strong> {{ $familyMember->deleter->name ?? 'System' }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN - Quick Actions & Audit Info -->
        <div class="col-lg-4">
            <!-- Quick Actions Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-bolt"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $role = strtolower(auth()->user()->roleMaster->role_name ?? auth()->user()->role ?? '');
                        $resident = App\Models\Resident::where('user_id', auth()->id())->first();
                        $isOwnFamily = ($resident && $resident->id == $familyMember->resident_id);
                    @endphp

                    @if(!$familyMember->trashed())
                        <!-- Edit Button - Admin or Own Family -->
                        @if($role == 'admin' || ($role == 'resident' && $isOwnFamily))
                        <a href="{{ route('family-members.edit', $familyMember->member_id) }}" class="action-btn btn-edit text-decoration-none">
                            <i class="fas fa-edit"></i>
                            Edit Member Details
                        </a>
                        @endif

                        <!-- View Resident Button -->
                        <!-- @if($familyMember->resident_id)
                        <a href="{{ route('residents.profile', $familyMember->resident_id) }}" class="action-btn btn-view-resident text-decoration-none">
                            <i class="fas fa-home"></i>
                            View Resident Details
                        </a>
                        @endif -->

                        <!-- Archive Button - Admin or Own Family -->
                        @if($role == 'admin' || ($role == 'resident' && $isOwnFamily))
                        <form action="{{ route('family-members.destroy', $familyMember->member_id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to archive this family member? It can be restored later.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn btn-archive">
                                <i class="fas fa-archive"></i>
                                Archive Member
                            </button>
                        </form>
                        @endif
                    @else
                        <!-- Restore Button - Admin or Own Family -->
                        @if($role == 'admin' || ($role == 'resident' && $isOwnFamily))
                        <form action="{{ route('family-members.restore', $familyMember->member_id) }}" method="POST"
                              onsubmit="return confirm('Restore this family member? It will be moved back to active members.')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="action-btn btn-restore">
                                <i class="fas fa-trash-restore"></i>
                                Restore Member
                            </button>
                        </form>
                        @endif

                        <!-- Force Delete Button - Admin Only -->
                        @if($role == 'admin')
                        <form action="{{ route('family-members.force-delete', $familyMember->member_id) }}" method="POST"
                              onsubmit="return confirm('WARNING: This will permanently delete this family member! This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn btn-danger-badge">
                                <i class="fas fa-trash"></i>
                                Delete Permanently
                            </button>
                        </form>
                        @endif
                    @endif

                    <!-- Print/Download Option -->
                    <button onclick="window.print()" class="action-btn" style="background: #f8f9fa; color: #212529; border: 1px solid #dee2e6;">
                        <i class="fas fa-print"></i>
                        Print Details
                    </button>
                </div>
            </div>

            <!-- Audit Trail Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-history"></i>
                        Audit Trail
                    </h5>
                </div>
                <div class="card-body">
                    <div class="audit-trail-item mb-3">
                        <div class="audit-label">Created By</div>
                        <div class="audit-value">
                            @if($familyMember->creator)
                                {{ $familyMember->creator->name ?? 'System' }}
                            @else
                                System
                            @endif
                        </div>
                        <small class="text-muted">{{ $familyMember->created_at ? $familyMember->created_at->format('d M Y h:i A') : '-' }}</small>
                    </div>

                    <div class="audit-trail-item mb-3">
                        <div class="audit-label">Last Updated By</div>
                        <div class="audit-value">
                            @if($familyMember->updater)
                                {{ $familyMember->updater->name ?? 'System' }}
                            @else
                                System
                            @endif
                        </div>
                        <small class="text-muted">{{ $familyMember->updated_at ? $familyMember->updated_at->format('d M Y h:i A') : '-' }}</small>
                    </div>

                    @if($familyMember->trashed() && $familyMember->deleter)
                    <div class="audit-trail-item mb-3" style="border-left-color: #dc2626;">
                        <div class="audit-label">Archived By</div>
                        <div class="audit-value">{{ $familyMember->deleter->name ?? 'System' }}</div>
                        <small class="text-muted">{{ $familyMember->deleted_at ? $familyMember->deleted_at->format('d M Y h:i A') : '-' }}</small>
                    </div>
                    @endif

                    <!-- Additional Stats -->
                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Status:</span>
                            <span class="fw-600">
                                @if($familyMember->activity_status)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Inactive</span>
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Member ID:</span>
                            <span class="fw-600">#{{ $familyMember->member_id }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Info Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-info-circle"></i>
                        Quick Info
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-building me-2 text-secondary"></i>Resident ID:</span>
                            <span class="fw-600">#{{ $familyMember->resident_id }}</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-phone me-2 text-secondary"></i>Has Mobile:</span>
                            <span class="fw-600">{{ $familyMember->mobile ? 'Yes' : 'No' }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span><i class="fas fa-clock me-2 text-secondary"></i>Member Age:</span>
                            <span class="fw-600">{{ $familyMember->created_at ? $familyMember->created_at->diffForHumans() : 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style media="print">
    .back-link, .detail-card .card-header, .action-btn, footer, nav, .btn-close, .modal {
        display: none !important;
    }
    .container-fluid {
        padding: 0 !important;
    }
    .detail-card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
        break-inside: avoid;
    }
    .col-lg-8, .col-lg-4 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
    }
    .row {
        display: block !important;
    }
    .info-grid {
        break-inside: avoid;
    }
    .avatar-large {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
    .relation-badge-large {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
</style>

@endsection

@push('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@push('scripts')
<script>
    // Print function is handled by browser's print
    // No additional JavaScript needed for this page
</script>
@endpush
