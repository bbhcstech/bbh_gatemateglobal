@extends('admin.layout.app')

@section('title', 'Archived Pet Details')

@section('content')
<style>
    /* Standard Admin Theme */
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

    /* Details Card */
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

    .pet-badge {
        background-color: #6c757d;
        color: white;
        padding: 5px 12px;
        border-radius: 3px;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* Details Grid */
    .details-grid {
        padding: 20px;
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 20px;
    }

    /* Image Section */
    .image-section {
        text-align: center;
    }

    .pet-main-image {
        width: 100%;
        height: 200px;
        border-radius: 3px;
        object-fit: cover;
        border: 1px solid #dee2e6;
        cursor: pointer;
    }

    .image-placeholder {
        width: 100%;
        height: 200px;
        border-radius: 3px;
        background-color: #f8f9fa;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        border: 1px solid #dee2e6;
    }

    .image-placeholder i {
        font-size: 3rem;
        margin-bottom: 10px;
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

    /* Info Section */
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

    .info-value-large {
        font-size: 1.2rem;
        font-weight: 600;
        color: #007bff;
    }

    /* Status Badge */
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

    /* Vaccination Badge */
    .vaccination-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 3px;
        font-size: 0.9rem;
    }

    .vaccination-badge-large.vaccinated { background-color: #d4edda; color: #155724; }
    .vaccination-badge-large.expiring { background-color: #fff3cd; color: #856404; }
    .vaccination-badge-large.expired { background-color: #f8d7da; color: #721c24; }

    /* Owner Card */
    .owner-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background-color: white;
        border-radius: 3px;
        border: 1px solid #dee2e6;
    }

    .owner-avatar {
        width: 50px;
        height: 50px;
        border-radius: 3px;
        background-color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .owner-details {
        flex: 1;
    }

    .owner-name-large {
        font-size: 1.1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 5px;
    }

    .owner-meta {
        display: flex;
        gap: 15px;
        color: #6c757d;
        font-size: 0.85rem;
        flex-wrap: wrap;
    }

    .owner-meta i {
        margin-right: 4px;
    }

    /* Dangerous Badge */
    .dangerous-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background-color: #f8d7da;
        color: #721c24;
        padding: 6px 12px;
        border-radius: 3px;
        font-size: 0.9rem;
        margin-left: 10px;
    }

    /* Action Buttons */
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
        border: 1px solid #28a745;
    }

    .btn-restore-large:hover {
        background-color: #218838;
        border-color: #1e7e34;
        color: white;
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
        border: 1px solid #dc3545;
    }

    .btn-delete-large:hover {
        background-color: #c82333;
        border-color: #bd2130;
        color: white;
    }

    .btn-secondary-large {
        background-color: #6c757d;
        border: 1px solid #6c757d;
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
        border-color: #545b62;
        color: white;
    }

    /* Deletion Info */
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

    /* Alert Messages */
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 3px;
        padding: 12px 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 3px;
        padding: 12px 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Responsive */
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

        .action-buttons a,
        .action-buttons button {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid py-3">
    <!-- Details Header -->
    <div class="details-header d-flex justify-content-between align-items-center">
        <div>
            <h1>
                <i class="fas fa-eye mr-2"></i>
                Archived Pet Details
            </h1>
            <p>Complete information about the archived pet</p>
        </div>
        <div>
            <a href="{{ route('pets.archived') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Archive
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Details Card -->
    <div class="details-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-info-circle"></i>
                Pet Information
            </h5>
            <span class="pet-badge">
                <i class="fas fa-archive"></i>
                Archived on {{ $pet->deleted_at ? $pet->deleted_at->format('d M Y, h:i A') : 'Unknown' }}
            </span>
        </div>

        <div class="details-grid">
            <!-- Image Section -->
            <div class="image-section">
                @if($pet->image && file_exists(public_path($pet->image)))
                    <img src="{{ asset($pet->image) }}"
                         class="pet-main-image"
                         alt="Pet Image"
                         onclick="previewImage('{{ asset($pet->image) }}')"
                         style="cursor: pointer;">
                @else
                    <div class="image-placeholder">
                        <i class="fas fa-paw"></i>
                        <span>No Image Available</span>
                    </div>
                @endif

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
                        <i class="fas fa-paw"></i>
                        Basic Information
                        @if($pet->is_dangerous)
                            <span class="dangerous-badge-large">
                                <i class="fas fa-exclamation-triangle"></i>
                                Dangerous Pet
                            </span>
                        @endif
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-tag"></i>
                                Pet Name
                            </span>
                            <span class="info-value-large">{{ $pet->pet_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-paw"></i>
                                Pet Type
                            </span>
                            <span class="info-value">{{ $pet->pet_type ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-dog"></i>
                                Breed
                            </span>
                            <span class="info-value">{{ $pet->pet_breed ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-calendar-alt"></i>
                                Age
                            </span>
                            <span class="info-value">{{ $pet->pet_age ? $pet->pet_age . ' years' : 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-palette"></i>
                                Color
                            </span>
                            <span class="info-value">{{ $pet->pet_color ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-{{ $pet->pet_gender == 'male' ? 'mars' : 'venus' }}"></i>
                                Gender
                            </span>
                            <span class="info-value">{{ $pet->pet_gender ? ucfirst($pet->pet_gender) : 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Owner Information -->
                <div class="info-group">
                    <div class="info-title">
                        <i class="fas fa-user"></i>
                        Owner Information
                    </div>
                    @if($pet->resident)
                        <div class="owner-card">
                            <div class="owner-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="owner-details">
                                <div class="owner-name-large">{{ $pet->resident->name ?? 'N/A' }}</div>
                                <div class="owner-meta">
                                    <span>
                                        <i class="fas fa-envelope"></i>
                                        {{ $pet->resident->email ?? 'N/A' }}
                                    </span>
                                    <span>
                                        <i class="fas fa-phone"></i>
                                        {{ $pet->resident->phone ?? 'N/A' }}
                                    </span>
                                </div>
                                @if($pet->flat)
                                    <div class="owner-meta" style="margin-top: 5px;">
                                        <span>
                                            <i class="fas fa-building"></i>
                                            Tower: {{ $pet->flat->tower ?? 'N/A' }}
                                        </span>
                                        <span>
                                            <i class="fas fa-door-open"></i>
                                            Flat No: {{ $pet->flat->flat_no ?? 'N/A' }}
                                        </span>
                                    </div>
                                @endif
                                @if($pet->collar_microchip_no)
                                    <div class="owner-meta" style="margin-top: 5px;">
                                        <span>
                                            <i class="fas fa-microchip"></i>
                                            Microchip: {{ $pet->collar_microchip_no }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div style="color: #6c757d; text-align: center; padding: 20px;">
                            <i class="fas fa-user-slash fa-2x mb-2"></i>
                            <p>Owner information not available</p>
                        </div>
                    @endif
                </div>

                <!-- Vaccination Information -->
                <div class="info-group">
                    <div class="info-title">
                        <i class="fas fa-syringe"></i>
                        Vaccination Information
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-check-circle"></i>
                                Vaccination Status
                            </span>
                            @php
                                $vaccinationClass = $pet->getVaccinationStatusClass();
                                $vaccinationText = $pet->getVaccinationStatusText();
                            @endphp
                            <span class="vaccination-badge-large {{ $vaccinationClass }}">
                                <i class="fas fa-{{ $vaccinationClass == 'vaccinated' ? 'check-circle' : ($vaccinationClass == 'expiring' ? 'exclamation-triangle' : 'times-circle') }}"></i>
                                {{ $vaccinationText }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-calendar-times"></i>
                                Expiry Date
                            </span>
                            <span class="info-value">
                                {{ $pet->vaccination_expiry_date ? $pet->vaccination_expiry_date->format('d M Y') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Status & Additional Info -->
                <div class="info-group">
                    <div class="info-title">
                        <i class="fas fa-chart-bar"></i>
                        Status & Additional Information
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-circle"></i>
                                Status (Before Deletion)
                            </span>
                            <span class="status-badge-large {{ $pet->activity_status ? 'status-active' : 'status-inactive' }}">
                                <i class="fas fa-{{ $pet->activity_status ? 'check-circle' : 'times-circle' }}"></i>
                                {{ $pet->activity_status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-calendar-check"></i>
                                Created At
                            </span>
                            <span class="info-value">
                                {{ $pet->created_at ? $pet->created_at->format('d M Y, h:i A') : 'N/A' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-calendar-alt"></i>
                                Last Updated
                            </span>
                            <span class="info-value">
                                {{ $pet->updated_at ? $pet->updated_at->format('d M Y, h:i A') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Deletion Information -->
                <div class="deletion-info">
                    <i class="fas fa-history"></i>
                    <div>
                        <strong>Soft Deleted:</strong> This pet was archived on
                        {{ $pet->deleted_at ? $pet->deleted_at->format('l, d F Y \a\t h:i A') : 'Unknown' }}
                        @if($pet->deleted_by)
                            <br><small>Deleted by: {{ $pet->deleted_by }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('pets.archived') }}" class="btn-secondary-large">
                <i class="fas fa-arrow-left"></i>
                Back to Archive
            </a>

            <!-- Restore Form -->
            <form action="{{ route('pets.restore', $pet->id) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Restore this pet? It will be moved back to active pets.')">
                @csrf
                @method('PUT')
                <button type="submit" class="btn-restore-large">
                    <i class="fas fa-trash-restore"></i>
                    Restore Pet
                </button>
            </form>

            <!-- Permanent Delete (Admin Only) -->
            @if(auth()->user()->role === 'admin')
                <form action="{{ route('pets.force-delete', $pet->id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('WARNING: This will permanently delete this pet! This action cannot be undone.')">
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

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image mr-1"></i>
                    Pet Image Preview
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-3">
                <img id="modalImage" class="img-fluid rounded" style="max-height: 500px;">
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

@push('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush
