@extends('admin.layout.app')

@section('title', 'View Pet Details')

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
        border-bottom: 2px solid #2563eb;
        padding: 16px 20px;
        border-radius: 12px 12px 0 0 !important;
    }

    .detail-card .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #2563eb;
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

    .image-preview {
        border: 2px solid #dee2e6;
        border-radius: 12px;
        padding: 4px;
        max-height: 250px;
        max-width: 100%;
        width: auto;
        margin: 0 auto;
        display: block;
    }

    .image-preview:hover {
        border-color: #2563eb;
        cursor: pointer;
        transform: scale(1.02);
        transition: all 0.3s ease;
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

    .status-vaccinated {
        background: #d1fae5;
        color: #059669;
    }

    .status-expiring {
        background: #fed7aa;
        color: #b45309;
    }

    .status-expired {
        background: #fee2e2;
        color: #dc2626;
    }

    .danger-badge-large {
        background: #fee2e2;
        color: #dc2626;
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .type-badge-large {
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .type-dog {
        background: #dbeafe;
        color: #1e40af;
    }

    .type-cat {
        background: #fef9c3;
        color: #854d0e;
    }

    .type-bird {
        background: #dcfce7;
        color: #166534;
    }

    .type-rabbit {
        background: #f3e8ff;
        color: #6b21a8;
    }

    .type-other {
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
        color: #2563eb;
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

    .btn-view-owner {
        background: #2563eb;
        color: white;
    }

    .btn-view-owner:hover {
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

    .btn-vaccination {
        background: #10b981;
        color: white;
        border: none;
    }

    .btn-vaccination:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
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

    .vaccination-progress {
        height: 8px;
        border-radius: 4px;
        background: #e9ecef;
        margin-top: 8px;
    }

    .vaccination-progress-bar {
        height: 8px;
        border-radius: 4px;
        background: #10b981;
    }

    .vaccination-progress-bar.expiring {
        background: #f59e0b;
    }

    .vaccination-progress-bar.expired {
        background: #ef4444;
    }

    .microchip-badge {
        background: #f3e8ff;
        color: #6b21a8;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
</style>

<div class="container-fluid py-4">
    <!-- Back Link -->
    <a href="{{ route('pets.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
        Back to Pet List
    </a>

    <div class="row g-4">
        <!-- LEFT COLUMN - Pet Details -->
        <div class="col-lg-8">
            <div class="detail-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-paw"></i>
                        Pet Details
                        @if($pet->is_dangerous)
                            <span class="danger-badge-large ms-3">
                                <i class="fas fa-exclamation-triangle"></i>
                                Dangerous Pet
                            </span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Pet Type Badge -->
                    @php
                        $type = strtolower($pet->pet_type ?? 'other');
                        $icon = 'paw';
                        if(str_contains($type, 'dog')) $icon = 'dog';
                        elseif(str_contains($type, 'cat')) $icon = 'cat';
                        elseif(str_contains($type, 'bird')) $icon = 'crow';
                        elseif(str_contains($type, 'rabbit')) $icon = 'rabbit';

                        $typeClass = 'type-other';
                        if(str_contains($type, 'dog')) $typeClass = 'type-dog';
                        elseif(str_contains($type, 'cat')) $typeClass = 'type-cat';
                        elseif(str_contains($type, 'bird')) $typeClass = 'type-bird';
                        elseif(str_contains($type, 'rabbit')) $typeClass = 'type-rabbit';
                    @endphp

                    <div class="mb-4 text-center">
                        <span class="type-badge-large {{ $typeClass }}">
                            <i class="fas fa-{{ $icon }}"></i>
                            {{ $pet->pet_type ?? 'Other' }}
                        </span>
                    </div>

                    <div class="info-grid">
                        <!-- Pet Name -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-tag" style="color: #2563eb;"></i>
                                Pet Name
                            </div>
                            <div class="info-value">{{ $pet->pet_name ?? '-' }}</div>
                        </div>

                        <!-- Pet Breed -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-dna" style="color: #2563eb;"></i>
                                Breed
                            </div>
                            <div class="info-value">{{ $pet->pet_breed ?? '-' }}</div>
                        </div>

                        <!-- Pet Gender -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-{{ $pet->pet_gender == 'male' ? 'mars' : 'venus' }}" style="color: #2563eb;"></i>
                                Gender
                            </div>
                            <div class="info-value">{{ ucfirst($pet->pet_gender ?? 'Not specified') }}</div>
                        </div>

                        <!-- Pet Age -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-calendar-alt" style="color: #2563eb;"></i>
                                Age
                            </div>
                            <div class="info-value">
                                @if($pet->pet_age)
                                    {{ $pet->pet_age }} {{ $pet->pet_age == 1 ? 'year' : 'years' }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <!-- Pet Color -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-palette" style="color: #2563eb;"></i>
                                Color
                            </div>
                            <div class="info-value">{{ $pet->pet_color ?? '-' }}</div>
                        </div>

                        <!-- Microchip Number -->
                        <div>
                            <div class="info-label">
                                <i class="fas fa-microchip" style="color: #2563eb;"></i>
                                Microchip / Collar Number
                            </div>
                            <div class="info-value">
                                @if($pet->collar_microchip_no)
                                    <span class="microchip-badge">
                                        <i class="fas fa-microchip"></i>
                                        {{ $pet->collar_microchip_no }}
                                    </span>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Owner Information -->
                    <div class="mt-4">
                        <div class="info-label">
                            <i class="fas fa-user" style="color: #2563eb;"></i>
                            Owner Information
                        </div>
                        <div class="info-value">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Name:</strong> {{ $pet->resident->name ?? '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Flat:</strong>
                                    @if($pet->resident && $pet->resident->flat)
                                        {{ $pet->resident->flat->flat_no ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </div>
                                @if($pet->resident)
                                <div class="col-md-6 mt-2">
                                    <strong>Contact:</strong> {{ $pet->resident->phone ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mt-2">
                                    <strong>Email:</strong> {{ $pet->resident->email ?? 'N/A' }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Registration Information -->
                    <div class="mt-4">
                        <div class="info-label">
                            <i class="fas fa-calendar" style="color: #2563eb;"></i>
                            Registration Information
                        </div>
                        <div class="info-value">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Added on:</strong> {{ $pet->created_at ? $pet->created_at->format('d M Y') : '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Last Updated:</strong> {{ $pet->updated_at ? $pet->updated_at->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pet Image -->
                    @if($pet->image && file_exists(public_path($pet->image)))
                    <div class="mt-4 text-center">
                        <div class="info-label mb-3">
                            <i class="fas fa-image" style="color: #2563eb;"></i>
                            Pet Image
                        </div>
                        <img src="{{ asset($pet->image) }}"
                             class="image-preview"
                             onclick="previewImage('{{ asset($pet->image) }}')"
                             style="max-height: 250px; cursor: pointer;"
                             alt="{{ $pet->pet_name }}"
                             title="Click to enlarge">
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN - Quick Actions & Vaccination Info -->
        <div class="col-lg-4">
            <!-- Vaccination Status Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-syringe"></i>
                        Vaccination Status
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $vaccinationClass = $pet->getVaccinationStatusClass();
                        $vaccinationText = $pet->getVaccinationStatusText();
                        $vaccinationIcon = match($vaccinationClass) {
                            'vaccinated' => 'fa-check-circle',
                            'expiring' => 'fa-exclamation-triangle',
                            'expired' => 'fa-times-circle',
                            default => 'fa-question-circle'
                        };
                    @endphp

                    <div class="text-center mb-4">
                        <span class="status-badge status-{{ $vaccinationClass }}" style="font-size: 1.1rem; padding: 10px 20px;">
                            <i class="fas {{ $vaccinationIcon }}"></i>
                            {{ $vaccinationText }}
                        </span>
                    </div>

                    @if($pet->vaccination_expiry_date && $pet->vaccination_status == 'yes')
                        @php
                            $expiryDate = \Carbon\Carbon::parse($pet->vaccination_expiry_date);
                            $daysRemaining = now()->diffInDays($expiryDate, false);
                            $totalDays = 365; // Assuming 1 year validity
                            $percentage = max(0, min(100, ($daysRemaining / $totalDays) * 100));
                        @endphp

                        <div class="mb-3">
                            <div class="info-label">Expiry Date</div>
                            <div class="fw-bold">{{ $expiryDate->format('d M Y') }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="info-label">Days Remaining</div>
                            <div class="fw-bold {{ $daysRemaining <= 30 ? 'text-warning' : ($daysRemaining <= 0 ? 'text-danger' : 'text-success') }}">
                                @if($daysRemaining > 0)
                                    {{ $daysRemaining }} days
                                @else
                                    Expired
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="info-label">Vaccination Validity</div>
                            <div class="vaccination-progress">
                                <div class="vaccination-progress-bar {{ $vaccinationClass }}"
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @elseif($pet->vaccination_status != 'yes')
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            This pet is not vaccinated. Please update vaccination status.
                        </div>
                    @endif

                    @if($pet->is_dangerous)
                        <div class="alert alert-danger mt-3 mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Warning:</strong> This pet is marked as dangerous. Handle with care.
                        </div>
                    @endif
                </div>
            </div>

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
                        $role = strtolower(auth()->user()->roleMaster->role_name ?? '');
                        $isOwnPet = ($role == 'resident' && auth()->id() == $pet->resident_id);
                    @endphp

                    <!-- Edit Button - Admin or Pet Owner -->
                    @if($role == 'admin' || ($role == 'resident' && $isOwnPet))
                    <a href="{{ route('pets.edit', $pet->id) }}" class="action-btn btn-edit text-decoration-none">
                        <i class="fas fa-edit"></i>
                        Edit Pet Details
                    </a>
                    @endif

                    <!-- View Owner Button -->
                    <!-- @if($pet->resident_id)
                    <a href="{{route('residents.profile', $pet->resident_id) }}" class="action-btn btn-view-owner text-decoration-none">
                        <i class="fas fa-user"></i>
                        View Owner Details
                    </a>
                    @endif -->


                <!-- Update Vaccination Button - Admin or Pet Owner -->
                    @if($role == 'admin' || ($role == 'resident' && $isOwnPet))
                        <a href="{{ route('pets.edit', $pet->id) }}" class="action-btn btn-vaccination" title="Edit Pet">
                            <i class="fas fa-edit"></i>
                               Update Vaccination
                        </a>
                    @endif


                    <!-- Toggle Dangerous Status - Admin Only -->
                    @if($role == 'admin')
                    <form action="{{ route('pets.toggle-dangerous', $pet->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to {{ $pet->is_dangerous ? 'remove' : 'mark as' }} dangerous status?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="action-btn btn-danger-badge">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $pet->is_dangerous ? 'Remove Dangerous' : 'Mark as Dangerous' }}
                        </button>
                    </form>
                    @endif

                    <!-- Archive Button - Admin or Pet Owner -->
                    @if($role == 'admin' || ($role == 'resident' && $isOwnPet))
                    <form action="{{ route('pets.destroy', $pet->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to archive this pet? It can be restored later.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-archive">
                            <i class="fas fa-archive"></i>
                            Archive Pet
                        </button>
                    </form>
                    @endif

                    <!-- Print/Download Option -->
                    <button onclick="window.print()" class="action-btn" style="background: #f8f9fa; color: #212529; border: 1px solid #dee2e6;">
                        <i class="fas fa-print"></i>
                        Print Details
                    </button>
                </div>
            </div>

            <!-- Activity Log Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-history"></i>
                        Activity Log
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted d-block">Added on</small>
                        <span>{{ $pet->created_at ? $pet->created_at->format('d M Y h:i A') : '-' }}</span>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted d-block">Last updated</small>
                        <span>{{ $pet->updated_at ? $pet->updated_at->format('d M Y h:i A') : '-' }}</span>
                    </div>

                    @if($pet->vaccination_expiry_date)
                    <div class="mb-2">
                        <small class="text-muted d-block">Vaccination valid until</small>
                        <span>{{ \Carbon\Carbon::parse($pet->vaccination_expiry_date)->format('d M Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vaccination Update Modal -->
<div class="modal fade" id="vaccinationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-syringe me-2" style="color: #2563eb;"></i>
                    Update Vaccination Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="vaccinationForm">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="vaccinationPetId" value="">

                    <div class="mb-3">
                        <label class="form-label">Vaccination Status</label>
                        <select class="form-select" id="vaccinationStatus" required>
                            <option value="vaccinated">Vaccinated</option>
                            <option value="expiring">Expiring Soon</option>
                            <option value="expired">Not Vaccinated / Expired</option>
                        </select>
                    </div>

                    <div class="mb-3" id="expiryDateGroup">
                        <label class="form-label">Expiry Date (if vaccinated)</label>
                        <input type="date" class="form-control" id="vaccinationExpiryDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="updateVaccinationStatus()">
                    <i class="fas fa-save me-2"></i>
                    Update Status
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image me-2" style="color: #2563eb;"></i>
                    Pet Image
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewModalImage" class="img-fluid rounded" style="max-height: 70vh;">
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
</style>

@endsection

@push('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@push('scripts')
<script>
    let vaccinationModal;
    let imagePreviewModal;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize modals
        const modalElement = document.getElementById('vaccinationModal');
        if (modalElement) {
            vaccinationModal = new bootstrap.Modal(modalElement);
        }

        const imageModalElement = document.getElementById('imagePreviewModal');
        if (imageModalElement) {
            imagePreviewModal = new bootstrap.Modal(imageModalElement);
        }

        // Show/hide expiry date based on status selection
        document.getElementById('vaccinationStatus')?.addEventListener('change', function() {
            const expiryDateGroup = document.getElementById('expiryDateGroup');
            if (this.value === 'vaccinated') {
                expiryDateGroup.style.display = 'block';
                document.getElementById('vaccinationExpiryDate').required = true;
            } else {
                expiryDateGroup.style.display = 'none';
                document.getElementById('vaccinationExpiryDate').required = false;
            }
        });
    });

    // Show vaccination modal
    function showVaccinationModal(petId) {
        document.getElementById('vaccinationPetId').value = petId;
        document.getElementById('vaccinationStatus').value = '{{ $pet->getVaccinationStatusClass() }}';

        @if($pet->vaccination_expiry_date)
        document.getElementById('vaccinationExpiryDate').value = '{{ $pet->vaccination_expiry_date->format('Y-m-d') }}';
        @endif

        // Trigger change event to show/hide expiry date
        document.getElementById('vaccinationStatus').dispatchEvent(new Event('change'));

        vaccinationModal.show();
    }

    // Update vaccination status
    function updateVaccinationStatus() {
        const petId = document.getElementById('vaccinationPetId').value;
        const status = document.getElementById('vaccinationStatus').value;
        const expiryDate = document.getElementById('vaccinationExpiryDate').value;
        const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        // Validate
        if (status === 'vaccinated' && !expiryDate) {
            alert('Please select expiry date for vaccination');
            return;
        }

        // Show loading
        const updateBtn = event.target;
        const originalText = updateBtn.innerHTML;
        updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
        updateBtn.disabled = true;

        fetch(`/pets/${petId}/vaccination`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: status,
                expiry_date: expiryDate
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                alert('Vaccination status updated successfully');
                // Reload page to show updated status
                window.location.reload();
            } else {
                throw new Error(data.message || 'Failed to update');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update vaccination status: ' + error.message);
        })
        .finally(() => {
            updateBtn.innerHTML = originalText;
            updateBtn.disabled = false;
        });
    }

    // Preview image
    function previewImage(src) {
        document.getElementById('previewModalImage').src = src;
        if (imagePreviewModal) {
            imagePreviewModal.show();
        }
    }
</script>
@endpush
