@extends('admin.layout.app')

@section('title', 'Archived Family Member Details')

@section('content')
<style>
    .details-header {
        background-color: #343a40;
        padding: 20px 25px;
        border-radius: 5px;
        margin-bottom: 25px;
        color: white;
    }

    .details-header h1 {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .details-header p {
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

    .details-card {
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

    .archived-badge {
        background-color: #6c757d;
        color: white;
        padding: 5px 12px;
        border-radius: 3px;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .details-grid {
        padding: 20px;
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 20px;
    }

    .avatar-section {
        text-align: center;
    }

    .member-avatar-large {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        border: 4px solid #dee2e6;
    }

    .member-avatar-large i {
        font-size: 4rem;
        color: white;
    }

    .deleted-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #f8d7da;
        color: #721c24;
        padding: 8px 15px;
        border-radius: 3px;
        font-size: 0.95rem;
        margin-top: 15px;
    }

    .info-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .info-group {
        background-color: #f8f9fa;
        border-radius: 3px;
        padding: 20px;
    }

    .info-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 10px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 3px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 500;
        color: #212529;
        padding: 5px 0;
    }

    .status-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 3px;
        font-size: 0.9rem;
    }

    .status-active { background-color: #d4edda; color: #155724; }
    .status-inactive { background-color: #f8d7da; color: #721c24; }

    .relation-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 3px;
        font-size: 0.9rem;
    }

    .relation-father { background-color: #dbeafe; color: #1e40af; }
    .relation-mother { background-color: #fce7f3; color: #9d174d; }
    .relation-son { background-color: #d1fae5; color: #065f46; }
    .relation-daughter { background-color: #fed7aa; color: #92400e; }
    .relation-spouse { background-color: #e2e8f0; color: #334155; }
    .relation-other { background-color: #f1f5f9; color: #475569; }

    .action-buttons {
        padding: 20px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        border-top: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }

    .btn-restore-large {
        background-color: #28a745;
        border: none;
        padding: 8px 20px;
        border-radius: 3px;
        color: white;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 0.95rem;
        text-decoration: none;
    }

    .btn-restore-large:hover {
        background-color: #218838;
    }

    .btn-delete-large {
        background-color: #dc3545;
        border: none;
        padding: 8px 20px;
        border-radius: 3px;
        color: white;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 0.95rem;
        text-decoration: none;
    }

    .btn-delete-large:hover {
        background-color: #c82333;
    }

    .btn-secondary-large {
        background-color: #6c757d;
        border: none;
        padding: 8px 20px;
        border-radius: 3px;
        color: white;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 0.95rem;
        text-decoration: none;
    }

    .btn-secondary-large:hover {
        background-color: #5a6268;
    }

    .deletion-info {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 3px;
        padding: 12px 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #721c24;
    }

    .deletion-info i {
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {
        .details-grid {
            grid-template-columns: 1fr;
        }
        .info-grid {
            grid-template-columns: 1fr;
        }
        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="container-fluid py-3">
    <!-- Details Header -->
    <div class="details-header d-flex justify-content-between align-items-center">
        <div>
            <h1>
                <i class="fas fa-eye mr-2"></i>
                Archived Family Member Details
            </h1>
            <p>Complete information about the archived family member</p>
        </div>
        <div>
            <a href="{{ route('family-members.archived') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Archive
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Details Card -->
    <div class="details-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-info-circle"></i>
                Family Member Information
            </h5>
            <span class="archived-badge">
                <i class="fas fa-archive"></i>
                Archived on {{ $familyMember->deleted_at ? $familyMember->deleted_at->format('d M Y, h:i A') : 'Unknown' }}
            </span>
        </div>

        <div class="details-grid">
            <!-- Avatar Section -->
            <div class="avatar-section">
                @php
                    $relationName = $familyMember->relation->name ?? 'Other';
                    $relationIcon = match(true) {
                        in_array($relationName, ['Father', 'Son', 'Brother', 'Grandfather']) => 'fa-male',
                        in_array($relationName, ['Mother', 'Daughter', 'Sister', 'Grandmother']) => 'fa-female',
                        $relationName == 'Spouse' => 'fa-heart',
                        default => 'fa-user'
                    };
                @endphp
                <div class="member-avatar-large">
                    <i class="fas {{ $relationIcon }}"></i>
                </div>
                <div class="deleted-badge-large">
                    <i class="fas fa-clock"></i>
                    Soft Deleted
                </div>
            </div>

            <!-- Info Section -->
            <div class="info-section">
                <!-- Basic Information -->
                <div class="info-group">
                    <div class="info-title">
                        <i class="fas fa-user"></i>
                        Basic Information
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Full Name</span>
                            <span class="info-value-large">{{ $familyMember->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Member ID</span>
                            <span class="info-value">#{{ $familyMember->member_id }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Relationship</span>
                            <span class="relation-badge-large relation-{{ strtolower($relationName) }}">
                                <i class="fas {{ $relationIcon }}"></i>
                                {{ $relationName }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Mobile Number</span>
                            <span class="info-value">{{ $familyMember->mobile ?? 'Not provided' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status (Before Deletion)</span>
                            <span class="status-badge-large {{ $familyMember->activity_status ? 'status-active' : 'status-inactive' }}">
                                {{ $familyMember->activity_status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Resident Information -->
                <div class="info-group">
                    <div class="info-title">
                        <i class="fas fa-home"></i>
                        Resident Information
                    </div>
                    @if($familyMember->resident)
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Resident Name</span>
                            <span class="info-value">{{ $familyMember->resident->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Flat Number</span>
                            <span class="info-value">{{ $familyMember->resident->flat_no ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Contact</span>
                            <span class="info-value">{{ $familyMember->resident->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $familyMember->resident->email ?? 'N/A' }}</span>
                        </div>
                    </div>
                    @else
                    <p class="text-muted">Resident information not available</p>
                    @endif
                </div>

                <!-- Audit Information -->
                <div class="info-group">
                    <div class="info-title">
                        <i class="fas fa-history"></i>
                        Audit Information
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Created At</span>
                            <span class="info-value">{{ $familyMember->created_at ? $familyMember->created_at->format('d M Y H:i') : 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Last Updated</span>
                            <span class="info-value">{{ $familyMember->updated_at ? $familyMember->updated_at->format('d M Y H:i') : 'N/A' }}</span>
                        </div>
                        @if($familyMember->creator)
                        <div class="info-item">
                            <span class="info-label">Created By</span>
                            <span class="info-value">{{ $familyMember->creator->name ?? 'System' }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Deletion Information -->
                <div class="deletion-info">
                    <i class="fas fa-history"></i>
                    <div>
                        <strong>Soft Deleted:</strong> This family member was archived on
                        {{ $familyMember->deleted_at ? $familyMember->deleted_at->format('l, d F Y \a\t h:i A') : 'Unknown' }}
                        @if($familyMember->deleter)
                            <br><small>Deleted by: {{ $familyMember->deleter->name }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('family-members.archived') }}" class="btn-secondary-large">
                <i class="fas fa-arrow-left"></i>
                Back to Archive
            </a>

            <!-- Restore Form -->
            <form action="{{ route('family-members.restore', $familyMember->member_id) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Restore this family member? It will be moved back to active members.')">
                @csrf
                @method('PUT')
                <button type="submit" class="btn-restore-large">
                    <i class="fas fa-trash-restore"></i>
                    Restore Member
                </button>
            </form>

            <!-- Permanent Delete (Admin Only) -->
            @if(auth()->user()->role === 'admin')
                <form action="{{ route('family-members.force-delete', $familyMember->member_id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('WARNING: This will permanently delete this family member! This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete-large">
                        <i class="fas fa-trash"></i>
                        Delete Permanently
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
