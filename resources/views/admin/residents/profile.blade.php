@extends('admin.layout.app')

@section('title', 'Resident Profile')

@section('content')
<style>
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

    .profile-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .profile-header {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        padding: 2rem;
        color: white;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        border: 4px solid rgba(255,255,255,0.3);
    }

    .profile-avatar i {
        font-size: 3rem;
        color: #2563eb;
    }

    .profile-name {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .profile-email {
        font-size: 1rem;
        opacity: 0.9;
    }

    .profile-body {
        padding: 2rem;
    }

    .info-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .info-item {
        padding: 1rem;
        background: #f8fafc;
        border-radius: 12px;
    }

    .info-label {
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .pets-table {
        width: 100%;
        border-collapse: collapse;
    }

    .pets-table th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 0.75rem;
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .pets-table td {
        padding: 0.75rem;
        color: #1e293b;
        font-size: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-active {
        background: #d1fae5;
        color: #059669;
    }

    .badge-inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-outline {
        background: white;
        border: 1px solid #e2e8f0;
        color: #64748b;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-outline:hover {
        background: #f8fafc;
        border-color: #2563eb;
        color: #2563eb;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        text-decoration: none;
    }

    .action-btn:hover {
        background: #f8fafc;
        border-color: #2563eb;
        color: #2563eb;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="header-title">
            <h2>
                <i class="fas fa-user-circle me-2" style="color: var(--primary);"></i>
                Resident Profile
            </h2>
            <p>View resident details and information</p>
        </div>
        <div>
            <a href="{{ route('pets.index') }}" class="btn-outline">
                <i class="fas fa-arrow-left me-2"></i>
                Back to Pets
            </a>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="d-flex align-items-center gap-4">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <div class="profile-name">{{ $resident->name ?? 'N/A' }}</div>
                    <div class="profile-email">{{ $resident->email ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <div class="profile-body">
            <!-- Personal Information -->
            <div class="info-section">
                <div class="section-title">
                    <i class="fas fa-info-circle" style="color: #2563eb;"></i>
                    Personal Information
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-phone"></i>
                            Phone Number
                        </div>
                        <div class="info-value">{{ $resident->phone ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-calendar"></i>
                            Member Since
                        </div>
                        <div class="info-value">
                            {{ $resident->created_at ? $resident->created_at->format('d M Y') : 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flat Information -->
            <div class="info-section">
                <div class="section-title">
                    <i class="fas fa-home" style="color: #2563eb;"></i>
                    Flat Information
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-door-open"></i>
                            Flat Number
                        </div>
                        <div class="info-value">{{ $resident->flat->flat_no ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-building"></i>
                            Tower
                        </div>
                        <div class="info-value">{{ $resident->flat->tower ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Pets Information -->
            @if(isset($pets) && $pets->count() > 0)
            <div class="info-section">
                <div class="section-title">
                    <i class="fas fa-paw" style="color: #2563eb;"></i>
                    Pets Owned ({{ $pets->count() }})
                </div>
                <div class="table-responsive">
                    <table class="pets-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Breed</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pets as $pet)
                            <tr>
                                <td>{{ $pet->pet_name }}</td>
                                <td>{{ $pet->pet_type }}</td>
                                <td>{{ $pet->pet_breed ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $pet->activity_status ? 'badge-active' : 'badge-inactive' }}">
                                        {{ $pet->activity_status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('pets.show', $pet->id) }}" class="action-btn" title="View Pet">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="info-section">
                <div class="section-title">
                    <i class="fas fa-paw" style="color: #2563eb;"></i>
                    Pets Owned
                </div>
                <div class="text-center py-4" style="color: #64748b;">
                    <i class="fas fa-paw fa-3x mb-3"></i>
                    <p>No pets registered for this resident</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
