@extends('admin.layout.app')

@section('title', 'All Residents\' Pets')

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
        background-color: #64748b;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Table */
    .table-responsive {
        padding: 1.5rem;
        overflow-x: auto;
    }

    .pet-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.5rem;
        min-width: 1000px;
    }

    .pet-table thead th {
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

    .pet-table tbody tr {
        background: white;
        border-radius: 12px;
        transition: all 0.2s;
    }

    .pet-table tbody tr:hover {
        background: #f8fafc;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .pet-table tbody td {
        padding: 1rem;
        color: #1e293b;
        font-size: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    /* Pet Image */
    .pet-thumb {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid #e2e8f0;
    }

    .pet-thumb-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        border: 2px solid #e2e8f0;
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
    }

    .status-active {
        background: #d1fae5;
        color: #059669;
    }

    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Vaccination Badge */
    .vaccination-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        white-space: nowrap;
    }

    .vaccination-badge.yes {
        background: #d1fae5;
        color: #059669;
    }

    .vaccination-badge.no {
        background: #fee2e2;
        color: #dc2626;
    }

    .vaccination-badge.expiring {
        background: #fed7aa;
        color: #c2410c;
    }

    .vaccination-badge.expired {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Dangerous Badge */
    .dangerous-badge {
        background: #fee2e2;
        color: #dc2626;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        font-size: 0.7rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        margin-left: 0.25rem;
    }

    /* Microchip */
    .microchip {
        font-size: 0.7rem;
        color: #64748b;
        background: #f1f5f9;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        display: inline-block;
        margin-top: 0.15rem;
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

    /* Modal */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    }

    .modal-header {
        background: white;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem;
    }

    .modal-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .modal-body {
        padding: 1.5rem;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="header-title">
            <h2>
                <i class="fas fa-users me-2" style="color: #2563eb;"></i>
                All Residents' Pets
            </h2>
            <p>View all pets registered in the society</p>
        </div>
        <div>
            <a href="{{ route('pets.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to My Pets
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-list"></i>
                All Pets Directory
            </h5>
            <span class="total-badge">
                <i class="fas fa-paw me-1"></i>
                Total: {{ $pets->count() }}
            </span>
        </div>

        <div class="table-responsive">
            @if($pets->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-paw"></i>
                    </div>
                    <h6>No pets found in the society</h6>
                </div>
            @else
                <table class="pet-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Pet Details</th>
                            <th>Owner</th>
                            <th>Flat</th>
                            <th>Vaccination</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pets as $key => $pet)
                            <tr>
                                <td>
                                    <span style="color: #64748b;">{{ $key + 1 }}</span>
                                </td>
                                <td>
                                    @if($pet->image && file_exists(public_path($pet->image)))
                                        <img src="{{ asset($pet->image) }}"
                                             class="pet-thumb"
                                             onclick="previewImage('{{ asset($pet->image) }}')"
                                             alt="Pet"
                                             onerror="this.onerror=null; this.src='{{ asset('images/default-pet.png') }}';"
                                             style="cursor: pointer;">
                                    @else
                                        <div class="pet-thumb-placeholder">
                                            <i class="fas fa-paw"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600;">
                                        {{ $pet->pet_name }}
                                        @if($pet->is_dangerous)
                                            <span class="dangerous-badge">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                Dangerous
                                            </span>
                                        @endif
                                    </div>
                                    <div style="font-size: 0.75rem; color: #64748b;">
                                        {{ $pet->pet_type ?? 'N/A' }}
                                        @if($pet->pet_breed)
                                            • {{ $pet->pet_breed }}
                                        @endif
                                        @if($pet->pet_age)
                                            • {{ $pet->pet_age }} yrs
                                        @endif
                                        @if($pet->pet_gender)
                                            • <i class="fas fa-{{ $pet->pet_gender == 'male' ? 'mars' : 'venus' }}"></i>
                                            {{ ucfirst($pet->pet_gender) }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 500;">{{ $pet->resident->name ?? 'N/A' }}</div>
                                    @if($pet->collar_microchip_no)
                                        <div class="microchip">
                                            <i class="fas fa-microchip"></i>
                                            {{ $pet->collar_microchip_no }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($pet->flat)
                                        <span style="font-weight: 500;">{{ $pet->flat->flat_no ?? 'N/A' }}</span>
                                        <div style="font-size: 0.7rem; color: #64748b;">
                                            {{ $pet->flat->tower ?? '' }}
                                        </div>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $vaccinationClass = $pet->vaccination_status == 'yes' ? 'yes' : 'no';
                                        $vaccinationText = $pet->vaccination_status == 'yes' ? 'Vaccinated' : 'Not Vaccinated';

                                        if($pet->vaccination_status == 'yes' && $pet->vaccination_expiry_date) {
                                            $daysLeft = now()->diffInDays($pet->vaccination_expiry_date, false);
                                            if($daysLeft <= 30 && $daysLeft > 0) {
                                                $vaccinationClass = 'expiring';
                                                $vaccinationText = 'Expiring Soon';
                                            } elseif($daysLeft <= 0) {
                                                $vaccinationClass = 'expired';
                                                $vaccinationText = 'Expired';
                                            }
                                        }
                                    @endphp
                                    <span class="vaccination-badge {{ $vaccinationClass }}">
                                        <i class="fas fa-{{ $vaccinationClass == 'yes' ? 'check-circle' : ($vaccinationClass == 'expiring' ? 'exclamation-triangle' : 'times-circle') }}"></i>
                                        {{ $vaccinationText }}
                                    </span>
                                    @if($pet->vaccination_expiry_date && $pet->vaccination_status == 'yes')
                                        <div style="font-size: 0.7rem; color: #64748b; margin-top: 0.25rem;">
                                            {{ $pet->vaccination_expiry_date->format('d M Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge {{ $pet->activity_status ? 'status-active' : 'status-inactive' }}">
                                        <i class="fas fa-{{ $pet->activity_status ? 'check-circle' : 'times-circle' }}"></i>
                                        {{ $pet->activity_status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('pets.show', $pet->id) }}" class="btn-view">
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

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image me-2"></i>
                    Pet Image
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" class="img-fluid rounded" style="max-height: 250px;">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let imageModal;

    document.addEventListener('DOMContentLoaded', function() {
        imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    });

    function previewImage(src) {
        document.getElementById('modalImage').src = src;
        imageModal.show();
    }
</script>
@endpush
