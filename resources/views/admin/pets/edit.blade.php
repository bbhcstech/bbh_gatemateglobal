@extends('admin.layout.app')

@section('title', 'Edit Pet')

@section('content')
<style>
    .edit-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        background: white;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .edit-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-bottom: none;
        padding: 20px 24px;
        border-radius: 16px 16px 0 0 !important;
    }

    .edit-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        color: white;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.25rem;
    }

    .edit-card .card-header h4 i {
        font-size: 1.5rem;
    }

    .edit-card .card-body {
        padding: 32px;
    }

    .form-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #e2e8f0;
    }

    .form-section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #2563eb;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e2e8f0;
    }

    .form-section-title i {
        font-size: 1.1rem;
    }

    .form-label {
        font-weight: 500;
        color: #475569;
        margin-bottom: 6px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-label i {
        color: #2563eb;
        font-size: 0.9rem;
    }

    .form-label .required {
        color: #dc2626;
        margin-left: 4px;
    }

    .form-control, .form-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 0.95rem;
        transition: all 0.2s;
        background-color: white;
    }

    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc2626;
    }

    .invalid-feedback {
        color: #dc2626;
        font-size: 0.8rem;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .image-preview {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        background: #f8fafc;
        margin-top: 8px;
    }

    .image-preview img {
        max-height: 150px;
        max-width: 100%;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .image-preview .btn-remove-image {
        color: #dc2626;
        background: white;
        border: 1px solid #dc2626;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .image-preview .btn-remove-image:hover {
        background: #dc2626;
        color: white;
    }

    .image-upload-area {
        border: 2px dashed #2563eb;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        background: #f0f9ff;
        cursor: pointer;
        transition: all 0.3s;
    }

    .image-upload-area:hover {
        background: #dbeafe;
        border-color: #1d4ed8;
    }

    .image-upload-area i {
        font-size: 2.5rem;
        color: #2563eb;
        margin-bottom: 10px;
    }

    .image-upload-area p {
        color: #475569;
        margin: 0;
        font-size: 0.9rem;
    }

    .image-upload-area small {
        color: #64748b;
        font-size: 0.8rem;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-cancel {
        background: white;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #334155;
    }

    .danger-checkbox {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        background: #fee2e2;
        border-radius: 8px;
        color: #dc2626;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .danger-checkbox:hover {
        background: #fecaca;
    }

    .danger-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .info-box {
        background: #e0f2fe;
        border-left: 4px solid #2563eb;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .info-box i {
        color: #2563eb;
        margin-right: 8px;
    }

    .info-box p {
        margin: 0;
        color: #1e293b;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .edit-card .card-body {
            padding: 20px;
        }

        .form-section {
            padding: 16px;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Back Link -->
    <a href="{{ route('pets.index') }}" class="back-link text-decoration-none mb-4 d-inline-flex align-items-center" style="color: #64748b;">
        <i class="fas fa-arrow-left me-2"></i>
        Back to Pet List
    </a>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="edit-card">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-paw"></i>
                        Edit Pet Details
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Error Alert -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Please fix the following errors:</strong>
                            </div>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Info Box -->
                    @php
                        $role = strtolower(auth()->user()->roleMaster->role_name ?? '');
                        $isOwnPet = ($role == 'resident' && auth()->id() == $pet->resident_id);
                    @endphp

                    @if($role == 'resident' && $isOwnPet)
                        <div class="info-box">
                            <i class="fas fa-info-circle"></i>
                            <span>You are editing your own pet. Changes will be visible to all residents.</span>
                        </div>
                    @elseif($role == 'admin')
                        <div class="info-box">
                            <i class="fas fa-user-shield"></i>
                            <span>Admin: You have full access to edit this pet's details.</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pets.update', $pet->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Owner Information Section -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-user"></i>
                                Owner Information
                            </div>

                            @if($role === 'admin')
                                <!-- Resident Selection for Admin -->
                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i>
                                        Resident <span class="required">*</span>
                                    </label>
                                    <select name="resident_id" class="form-select @error('resident_id') is-invalid @enderror" required>
                                        <option value="">-- Select Resident --</option>
                                        @foreach($residents as $resident)
                                            <option value="{{ $resident->id }}"
                                                {{ old('resident_id', $pet->resident_id) == $resident->id ? 'selected' : '' }}>
                                                {{ $resident->name }}
                                                @if($resident->flat)
                                                    (Flat: {{ $resident->flat->flat_no ?? 'N/A' }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('resident_id')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Flat Selection for Admin -->
                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-home"></i>
                                        Flat
                                    </label>
                                    <select name="flat_id" class="form-select @error('flat_id') is-invalid @enderror">
                                        <option value="">-- Select Flat --</option>
                                        @foreach($flats as $flat)
                                            <option value="{{ $flat->id }}"
                                                {{ old('flat_id', $pet->flat_id) == $flat->id ? 'selected' : '' }}>
                                                {{ $flat->flat_no }}
                                                @if($flat->resident)
                                                    ({{ $flat->resident->name }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('flat_id')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted d-block mt-1">Optional: Will auto-fill from resident if not selected</small>
                                </div>
                            @else
                                <!-- Resident Hidden Field -->
                                <input type="hidden" name="resident_id" value="{{ auth()->id() }}">
                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i>
                                        Resident
                                    </label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled readonly>
                                    @if(auth()->user()->flat)
                                        <small class="text-muted d-block mt-1">
                                            <i class="fas fa-home"></i> Flat: {{ auth()->user()->flat->flat_no ?? 'N/A' }}
                                        </small>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Pet Details Section -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-paw"></i>
                                Pet Details
                            </div>

                            <div class="row">
                                <!-- Pet Type -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-tag"></i>
                                        Pet Type <span class="required">*</span>
                                    </label>
                                    <select name="pet_type" class="form-select @error('pet_type') is-invalid @enderror" required>
                                        <option value="">-- Select Type --</option>
                                        @foreach($petsNames as $petType)
                                            <option value="{{ $petType->name }}"
                                                {{ old('pet_type', $pet->pet_type) == $petType->name ? 'selected' : '' }}>
                                                {{ $petType->name }}
                                            </option>
                                        @endforeach
                                        <option value="other" {{ old('pet_type', $pet->pet_type) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('pet_type')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Pet Name -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-signature"></i>
                                        Pet Name <span class="required">*</span>
                                    </label>
                                    <input type="text"
                                           name="pet_name"
                                           class="form-control @error('pet_name') is-invalid @enderror"
                                           value="{{ old('pet_name', $pet->pet_name) }}"
                                           placeholder="Enter pet name"
                                           required>
                                    @error('pet_name')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Pet Breed -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-dna"></i>
                                        Breed
                                    </label>
                                    <input type="text"
                                           name="pet_breed"
                                           class="form-control @error('pet_breed') is-invalid @enderror"
                                           value="{{ old('pet_breed', $pet->pet_breed) }}"
                                           placeholder="e.g., Labrador, Persian, etc.">
                                    @error('pet_breed')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Pet Gender -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-venus-mars"></i>
                                        Gender
                                    </label>
                                    <select name="pet_gender" class="form-select @error('pet_gender') is-invalid @enderror">
                                        <option value="">-- Select Gender --</option>
                                        <option value="male" {{ old('pet_gender', $pet->pet_gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('pet_gender', $pet->pet_gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('pet_gender')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Pet Color -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-palette"></i>
                                        Color
                                    </label>
                                    <input type="text"
                                           name="pet_color"
                                           class="form-control @error('pet_color') is-invalid @enderror"
                                           value="{{ old('pet_color', $pet->pet_color) }}"
                                           placeholder="e.g., Brown, White, Black">
                                    @error('pet_color')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Pet Age -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-calendar"></i>
                                        Age (years)
                                    </label>
                                    <input type="number"
                                           name="pet_age"
                                           class="form-control @error('pet_age') is-invalid @enderror"
                                           value="{{ old('pet_age', $pet->pet_age) }}"
                                           min="0"
                                           step="1"
                                           placeholder="Enter age">
                                    @error('pet_age')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Identification & Vaccination Section -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-microchip"></i>
                                Identification & Vaccination
                            </div>

                            <div class="row">
                                <!-- Microchip/Collar Number -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-microchip"></i>
                                        Microchip / Collar Number
                                    </label>
                                    <input type="text"
                                           name="collar_microchip_no"
                                           class="form-control @error('collar_microchip_no') is-invalid @enderror"
                                           value="{{ old('collar_microchip_no', $pet->collar_microchip_no) }}"
                                           placeholder="Enter microchip or collar number">
                                    @error('collar_microchip_no')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Vaccination Status -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-syringe"></i>
                                        Vaccination Status
                                    </label>
                                    <select name="vaccination_status" class="form-select @error('vaccination_status') is-invalid @enderror">
                                        <option value="no" {{ old('vaccination_status', $pet->vaccination_status) == 'no' ? 'selected' : '' }}>Not Vaccinated</option>
                                        <option value="yes" {{ old('vaccination_status', $pet->vaccination_status) == 'yes' ? 'selected' : '' }}>Vaccinated</option>
                                    </select>
                                    @error('vaccination_status')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Vaccination Expiry Date -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        Vaccination Expiry Date
                                    </label>
                                    <input type="date"
                                           name="vaccination_expiry_date"
                                           class="form-control @error('vaccination_expiry_date') is-invalid @enderror"
                                           value="{{ old('vaccination_expiry_date', $pet->vaccination_expiry_date ? $pet->vaccination_expiry_date->format('Y-m-d') : '') }}">
                                    @error('vaccination_expiry_date')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted d-block mt-1">Required if vaccinated</small>
                                </div>
                            </div>

                            <!-- Dangerous Checkbox -->
                            @if($role == 'admin' || ($role == 'resident' && $isOwnPet))
                                <div class="mb-4">
                                    <label class="danger-checkbox">
                                        <input type="checkbox"
                                               name="is_dangerous"
                                               value="1"
                                               {{ old('is_dangerous', $pet->is_dangerous) ? 'checked' : '' }}>
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Mark as Dangerous Pet
                                    </label>
                                    <small class="text-muted d-block mt-1">
                                        <i class="fas fa-info-circle"></i>
                                        Dangerous pets will be highlighted with warning badges
                                    </small>
                                </div>
                            @endif
                        </div>

                        <!-- Image Upload Section -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-image"></i>
                                Pet Image
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Current Image Preview -->
                                    @if($pet->image && file_exists(public_path($pet->image)))
                                        <div class="image-preview mb-3" id="currentImagePreview">
                                            <img src="{{ asset($pet->image) }}" alt="Current Pet Image">
                                            <p class="mb-2">Current Image</p>
                                            <button type="button" class="btn-remove-image" onclick="removeCurrentImage()">
                                                <i class="fas fa-times"></i>
                                                Remove Current Image
                                            </button>
                                            <input type="hidden" name="remove_current_image" id="removeCurrentImage" value="0">
                                        </div>
                                    @endif

                                    <!-- New Image Upload -->
                                    <div class="image-upload-area" onclick="document.getElementById('imageInput').click()">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p>Click to upload new image</p>
                                        <small class="text-muted">Supports: JPG, JPEG, PNG, WEBP (Max: 2MB)</small>
                                    </div>
                                    <input type="file"
                                           id="imageInput"
                                           name="image"
                                           class="d-none"
                                           accept="image/jpeg,image/png,image/webp"
                                           onchange="previewNewImage(this)">
                                    <div id="newImagePreview" class="image-preview mt-3" style="display: none;">
                                        <img id="newImage" src="" alt="New Image Preview">
                                        <p class="mb-2">New Image Preview</p>
                                        <button type="button" class="btn-remove-image" onclick="clearNewImage()">
                                            <i class="fas fa-times"></i>
                                            Cancel
                                        </button>
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <!-- Archive Button -->
                                @if($role == 'admin' || ($role == 'resident' && $isOwnPet))
                                    <button type="button" class="btn btn-outline-danger" onclick="confirmArchive()">
                                        <i class="fas fa-archive"></i>
                                        Archive Pet
                                    </button>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('pets.index') }}" class="btn-cancel">
                                    <i class="fas fa-times"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-save"></i>
                                    Update Pet
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Archive Form -->
@if($role == 'admin' || ($role == 'resident' && $isOwnPet))
<form id="archiveForm" action="{{ route('pets.destroy', $pet->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endif

<!-- JavaScript -->
<script>
    // Remove current image
    function removeCurrentImage() {
        if (confirm('Are you sure you want to remove the current image?')) {
            document.getElementById('removeCurrentImage').value = '1';
            document.getElementById('currentImagePreview').style.display = 'none';
        }
    }

    // Preview new image
    function previewNewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('newImage').src = e.target.result;
                document.getElementById('newImagePreview').style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Clear new image
    function clearNewImage() {
        document.getElementById('imageInput').value = '';
        document.getElementById('newImagePreview').style.display = 'none';
    }

    // Confirm archive
    function confirmArchive() {
        if (confirm('Are you sure you want to archive this pet? It can be restored later from the archive page.')) {
            document.getElementById('archiveForm').submit();
        }
    }

    // Show/hide expiry date based on vaccination status
    document.addEventListener('DOMContentLoaded', function() {
        const vaccinationStatus = document.querySelector('select[name="vaccination_status"]');
        const expiryDateInput = document.querySelector('input[name="vaccination_expiry_date"]');

        function toggleExpiryDate() {
            if (vaccinationStatus.value === 'yes') {
                expiryDateInput.disabled = false;
                expiryDateInput.required = true;
                expiryDateInput.closest('.col-md-6').style.opacity = '1';
            } else {
                expiryDateInput.disabled = true;
                expiryDateInput.required = false;
                expiryDateInput.value = '';
                expiryDateInput.closest('.col-md-6').style.opacity = '0.6';
            }
        }

        if (vaccinationStatus && expiryDateInput) {
            vaccinationStatus.addEventListener('change', toggleExpiryDate);
            toggleExpiryDate(); // Initialize
        }
    });
</script>

<style>
    /* Additional styles for disabled fields */
    input:disabled, select:disabled {
        background-color: #f1f5f9 !important;
        cursor: not-allowed;
    }
</style>
@endsection
