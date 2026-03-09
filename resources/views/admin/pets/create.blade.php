@extends('admin.layout.app')

@section('title', 'Add Pet')

@section('content')
<style>
    /* Professional Industry Standard Theme */
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --primary-light: #3b82f6;
        --secondary: #64748b;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #1e293b;
        --light: #f8fafc;
        --border: #e2e8f0;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container-fluid {
        background: #f1f5f9;
        min-height: 100vh;
        padding: 2rem !important;
    }

    /* Header Section */
    .page-header {
        background: white;
        border-radius: 20px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid var(--border);
    }

    .header-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
    }

    .header-icon span {
        font-size: 2rem;
        filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.1));
    }

    .header-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--dark);
        line-height: 1.2;
        margin-bottom: 0.25rem;
    }

    .header-subtitle {
        color: var(--secondary);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .header-subtitle i {
        color: var(--primary);
        font-size: 0.75rem;
    }

    /* Error Alert */
    .alert-custom {
        background: #fef2f2;
        border-left: 4px solid var(--danger);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(239, 68, 68, 0.1);
    }

    .alert-custom strong {
        color: #991b1b;
        font-size: 1rem;
        display: block;
        margin-bottom: 0.5rem;
    }

    .alert-custom ul {
        color: #b91c1c;
        margin: 0;
        padding-left: 1.5rem;
        font-size: 0.875rem;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }

    .card-header-custom {
        background: #f9fafc;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border);
    }

    .card-header-custom h5 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
    }

    .card-header-custom h5 i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    /* Form Elements */
    .form-section {
        padding: 2rem;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px dashed var(--border);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--primary);
        font-size: 1rem;
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: var(--primary);
        font-size: 0.875rem;
        width: 16px;
    }

    .mandatory-badge {
        background: #fee2e2;
        color: var(--danger);
        font-size: 0.625rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        margin-left: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .optional-badge {
        background: #f1f5f9;
        color: var(--secondary);
        font-size: 0.625rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        margin-left: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        color: var(--dark);
        transition: all 0.2s ease;
        background: white;
    }

    .form-control:hover, .form-select:hover {
        border-color: var(--primary-light);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .form-control[readonly] {
        background-color: #f8fafc;
        border-color: var(--border);
        color: var(--secondary);
        cursor: not-allowed;
    }

    /* Combo Field Styling */
    .combo-wrapper {
        background: #f8fafc;
        border-radius: 16px;
        padding: 1rem;
        border: 1px solid var(--border);
    }

    .combo-field {
        margin-bottom: 0.75rem;
    }

    .combo-field:last-child {
        margin-bottom: 0;
    }

    /* Image Upload */
    .upload-container {
        background: #f8fafc;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border);
    }

    .image-upload-area {
        border: 2px dashed var(--primary);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        background: #f0f9ff;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .image-upload-area:hover {
        background: #e0f2fe;
        border-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -10px rgba(37, 99, 235, 0.3);
    }

    .image-upload-icon {
        color: var(--primary);
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
    }

    .image-upload-text {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .image-upload-subtext {
        color: var(--secondary);
        font-size: 0.75rem;
    }

    .preview-container {
        position: relative;
        display: inline-block;
        margin-top: 1rem;
    }

    .preview-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 16px;
        border: 4px solid white;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .remove-image {
        position: absolute;
        top: -8px;
        right: -8px;
        background: var(--danger);
        color: white;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3);
        transition: all 0.2s;
    }

    .remove-image:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    /* Danger Alert Box */
    .danger-box {
        background: #fff7f7;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid #fecaca;
        margin-top: 1rem;
    }

    /* Vaccination Box */
    .vaccination-box {
        background: #f0f9ff;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid #bae6fd;
    }

    /* Gender Toggle */
    .gender-toggle {
        display: flex;
        gap: 1rem;
        padding: 0.5rem 0;
    }

    .gender-option {
        flex: 1;
        position: relative;
    }

    .gender-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .gender-option label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 500;
        color: var(--secondary);
    }

    .gender-option input[type="radio"]:checked + label {
        background: var(--primary-light);
        border-color: var(--primary);
        color: var(--primary-dark);
    }

    .gender-option label:hover {
        border-color: var(--primary);
        background: #f0f9ff;
    }

    .gender-option i {
        font-size: 1.1rem;
    }

    /* Buttons */
    .action-buttons {
        background: #f9fafc;
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
    }

    .btn-secondary {
        background: white;
        color: var(--secondary);
        border: 1.5px solid var(--border);
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: var(--secondary);
        color: var(--dark);
        transform: translateY(-2px);
    }

    /* Validation */
    .invalid-feedback {
        color: var(--danger);
        font-size: 0.75rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .is-invalid {
        border-color: var(--danger) !important;
    }

    /* Responsive Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    @media (max-width: 992px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Loading State */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="page-header">
        <div class="d-flex align-items-center">
            <div class="header-icon">
                <span>🐾</span>
            </div>
            <div>
                <h1 class="header-title">Add New Pet</h1>
                <div class="header-subtitle">
                    <i class="fas fa-circle"></i>
                    <span>Register a new pet for society resident</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="alert-custom">
            <strong><i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <div class="card-header-custom">
            <h5>
                <i class="fas fa-paw"></i>
                Pet Registration Form
            </h5>
        </div>

        <div class="form-section">
            <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data" id="petForm">
                @csrf

                <!-- Mandatory Fields Section -->
                <div class="section-title">
                    <i class="fas fa-asterisk text-danger"></i>
                    Required Information
                </div>

                <div class="row g-4">
                    <!-- Owner Name - Mandatory -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-user-circle"></i>
                            Owner Name
                            <span class="mandatory-badge">Required</span>
                        </label>

                        @if(auth()->user()->role === 'admin')
                            <select name="resident_id" class="form-select @error('resident_id') is-invalid @enderror" required>
                                <option value="">Select Owner</option>
                                @foreach($residents as $resident)
                                    <option value="{{ $resident->id }}"
                                        {{ old('resident_id') == $resident->id ? 'selected' : '' }}>
                                        {{ $resident->name }} - Flat {{ $resident->flat?->flat_no ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            @php
                                $loggedInResident = auth()->user();
                            @endphp

                            <input type="text"
                                   class="form-control"
                                   value="{{ auth()->user()->name }}"
                                   readonly>

                            <input type="hidden" name="resident_id" value="{{ auth()->id() }}">
                        @endif

                        @error('resident_id')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Flat - Auto-populated -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-home"></i>
                            Flat Number
                            <span class="mandatory-badge">Required</span>
                        </label>

                        @if(auth()->user()->role === 'admin')
                            <select name="flat_id" class="form-select @error('flat_id') is-invalid @enderror" required>
                                <option value="">Select Flat</option>
                                @foreach($flats as $flat)
                                    <option value="{{ $flat->id }}"
                                        {{ old('flat_id') == $flat->id ? 'selected' : '' }}>
                                        {{ $flat->flat_no }} - {{ $flat->tower?->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="text"
                                   class="form-control"
                                   value="Flat {{ auth()->user()->flat?->flat_no ?? 'Not Assigned' }}"
                                   readonly>
                            <input type="hidden" name="flat_id" value="{{ auth()->user()->flat_id }}">
                        @endif

                        @error('flat_id')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Pet Name - Mandatory -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-tag"></i>
                            Pet Name
                            <span class="mandatory-badge">Required</span>
                        </label>
                        <div class="combo-wrapper">
                            <div class="combo-field">
                                <select id="pet_name_select" class="form-select" onchange="updatePetName()">
                                    <option value="">Select Pet Name</option>
                                    @foreach($petsNames as $petName)
                                        <option value="{{ $petName->name }}" {{ old('pet_name') == $petName->name ? 'selected' : '' }}>
                                            {{ $petName->name }}
                                        </option>
                                    @endforeach
                                    <option value="Other">Other (Specify)</option>
                                </select>
                            </div>
                            <div class="combo-field">
                                <input type="text"
                                       id="pet_name_input"
                                       name="pet_name"
                                       class="form-control @error('pet_name') is-invalid @enderror"
                                       value="{{ old('pet_name') }}"
                                       placeholder="Enter pet name"
                                       required>
                            </div>
                        </div>
                        @error('pet_name')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Pet Type - Mandatory -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-paw"></i>
                            Pet Type
                            <span class="mandatory-badge">Required</span>
                        </label>
                        <div class="combo-wrapper">
                            <div class="combo-field">
                                <select id="pet_type_select" class="form-select" onchange="updatePetType()">
                                    <option value="">Select Type</option>
                                    <option value="Dog" {{ old('pet_type') == 'Dog' ? 'selected' : '' }}>Dog</option>
                                    <option value="Cat" {{ old('pet_type') == 'Cat' ? 'selected' : '' }}>Cat</option>
                                    <option value="Bird" {{ old('pet_type') == 'Bird' ? 'selected' : '' }}>Bird</option>
                                    <option value="Fish" {{ old('pet_type') == 'Fish' ? 'selected' : '' }}>Fish</option>
                                    <option value="Rabbit" {{ old('pet_type') == 'Rabbit' ? 'selected' : '' }}>Rabbit</option>
                                    <option value="Hamster" {{ old('pet_type') == 'Hamster' ? 'selected' : '' }}>Hamster</option>
                                    <option value="Other">Other (Specify)</option>
                                </select>
                            </div>
                            <div class="combo-field">
                                <input type="text"
                                       id="pet_type_input"
                                       name="pet_type"
                                       class="form-control @error('pet_type') is-invalid @enderror"
                                       value="{{ old('pet_type') }}"
                                       placeholder="Enter pet type"
                                       required>
                            </div>
                        </div>
                        @error('pet_type')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Pet Breed -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-dog"></i>
                            Breed
                            <span class="optional-badge">Optional</span>
                        </label>
                        <input type="text"
                               name="pet_breed"
                               class="form-control @error('pet_breed') is-invalid @enderror"
                               value="{{ old('pet_breed') }}"
                               placeholder="e.g., Labrador, Persian, etc.">
                        @error('pet_breed')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pet Age -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt"></i>
                            Age (Years)
                            <span class="optional-badge">Optional</span>
                        </label>
                        <input type="number"
                               name="pet_age"
                               class="form-control @error('pet_age') is-invalid @enderror"
                               value="{{ old('pet_age') }}"
                               placeholder="e.g., 3"
                               min="0"
                               step="0.5">
                        @error('pet_age')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pet Color -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-palette"></i>
                            Color
                            <span class="optional-badge">Optional</span>
                        </label>
                        <input type="text"
                               name="pet_color"
                               class="form-control @error('pet_color') is-invalid @enderror"
                               value="{{ old('pet_color') }}"
                               placeholder="e.g., Brown, White, Black">
                        @error('pet_color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pet Gender -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-venus-mars"></i>
                            Gender
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="gender-toggle">
                            <div class="gender-option">
                                <input type="radio" name="pet_gender" value="male" id="gender_male" {{ old('pet_gender') == 'male' ? 'checked' : '' }}>
                                <label for="gender_male">
                                    <i class="fas fa-mars"></i>
                                    Male
                                </label>
                            </div>
                            <div class="gender-option">
                                <input type="radio" name="pet_gender" value="female" id="gender_female" {{ old('pet_gender') == 'female' ? 'checked' : '' }}>
                                <label for="gender_female">
                                    <i class="fas fa-venus"></i>
                                    Female
                                </label>
                            </div>
                        </div>
                        @error('pet_gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Collar/Microchip Number -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-microchip"></i>
                            Collar/Microchip Number
                            <span class="optional-badge">Optional</span>
                        </label>
                        <input type="text"
                               name="collar_microchip_no"
                               class="form-control @error('collar_microchip_no') is-invalid @enderror"
                               value="{{ old('collar_microchip_no') }}"
                               placeholder="e.g., MICRO123456">
                        @error('collar_microchip_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pet Image - Mandatory -->
                    <div class="col-12">
                        <label class="form-label">
                            <i class="fas fa-camera"></i>
                            Pet Image
                            <span class="mandatory-badge">Required</span>
                        </label>
                        <div class="upload-container">
                            <div class="image-upload-area" onclick="document.getElementById('pet_image').click()">
                                <div class="image-upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="image-upload-text">
                                    Click to upload pet image
                                </div>
                                <div class="image-upload-subtext">
                                    JPG, PNG up to 5MB
                                </div>
                            </div>

                            <input type="file"
                                   id="pet_image"
                                   name="image"
                                   class="d-none"
                                   accept="image/*"
                                   onchange="previewImage(event)"
                                   required>

                            <div id="previewContainer" class="text-center d-none">
                                <div class="preview-container">
                                    <img id="imagePreview" class="preview-image">
                                    <button type="button" class="remove-image" onclick="removeImage()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>

                            @error('image')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-times-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Vaccination Information Section -->
                <div class="section-title mt-5">
                    <i class="fas fa-syringe"></i>
                    Vaccination Information
                </div>

                <div class="vaccination-box">
                    <div class="row g-4">
                        <!-- Vaccination Status -->
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-check-circle"></i>
                                Vaccination Status
                                <span class="optional-badge">Optional</span>
                            </label>
                            <select name="vaccination_status" class="form-select" id="vaccination_status">
                                <option value="no" {{ old('vaccination_status', 'no') == 'no' ? 'selected' : '' }}>Not Vaccinated</option>
                                <option value="yes" {{ old('vaccination_status') == 'yes' ? 'selected' : '' }}>Vaccinated</option>
                            </select>
                        </div>

                        <!-- Vaccination Expiry Date -->
                        <div class="col-md-6" id="expiry_date_container" style="{{ old('vaccination_status') == 'yes' ? '' : 'display: none;' }}">
                            <label class="form-label">
                                <i class="fas fa-calendar-times"></i>
                                Vaccination Expiry Date
                                <span class="optional-badge">Optional</span>
                            </label>
                            <input type="date"
                                   name="vaccination_expiry_date"
                                   class="form-control @error('vaccination_expiry_date') is-invalid @enderror"
                                   value="{{ old('vaccination_expiry_date') }}"
                                   min="{{ date('Y-m-d') }}">
                            @error('vaccination_expiry_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Dangerous Pet Information -->
                <div class="section-title mt-5">
                    <i class="fas fa-exclamation-triangle"></i>
                    Additional Information
                </div>

                <div class="danger-box">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               name="is_dangerous"
                               value="1"
                               id="dangerousCheckbox"
                               {{ old('is_dangerous') ? 'checked' : '' }}>
                        <label class="form-check-label" for="dangerousCheckbox">
                            <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                            Mark as Dangerous Pet
                        </label>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle me-1"></i>
                        Check this if the pet requires special handling or is considered dangerous
                    </small>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('pets.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Save Pet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Image Preview
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                document.getElementById('pet_image').value = '';
                return;
            }

            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Please upload a valid image file (JPG, PNG, WEBP)');
                document.getElementById('pet_image').value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('imagePreview');
                img.src = e.target.result;
                document.getElementById('previewContainer').classList.remove('d-none');
                document.querySelector('.image-upload-area').classList.add('d-none');
            }
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        document.getElementById('pet_image').value = '';
        document.getElementById('previewContainer').classList.add('d-none');
        document.querySelector('.image-upload-area').classList.remove('d-none');
    }

    // Pet Name handler
    function updatePetName() {
        const select = document.getElementById('pet_name_select');
        const input = document.getElementById('pet_name_input');

        if (select.value === 'Other') {
            input.value = '';
            input.focus();
            input.readOnly = false;
        } else if (select.value) {
            input.value = select.value;
            input.readOnly = true;
        } else {
            input.value = '';
            input.readOnly = false;
        }
    }

    // Pet Type handler
    function updatePetType() {
        const select = document.getElementById('pet_type_select');
        const input = document.getElementById('pet_type_input');

        if (select.value === 'Other') {
            input.value = '';
            input.focus();
            input.readOnly = false;
        } else if (select.value) {
            input.value = select.value;
            input.readOnly = true;
        } else {
            input.value = '';
            input.readOnly = false;
        }
    }

    // Vaccination status toggle
    document.getElementById('vaccination_status').addEventListener('change', function() {
        const expiryContainer = document.getElementById('expiry_date_container');
        if (this.value === 'yes') {
            expiryContainer.style.display = 'block';
        } else {
            expiryContainer.style.display = 'none';
            document.querySelector('input[name="vaccination_expiry_date"]').value = '';
        }
    });

    // Form submission loading state
    document.getElementById('petForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        submitBtn.classList.add('loading');
    });

    // Initialize form with old values
    document.addEventListener('DOMContentLoaded', function() {
        // Set pet name select if old value matches predefined options
        const petNameInput = document.getElementById('pet_name_input');
        const petNameSelect = document.getElementById('pet_name_select');

        if (petNameInput.value) {
            const options = Array.from(petNameSelect.options);
            const matchingOption = options.find(option => option.value === petNameInput.value);
            if (matchingOption) {
                petNameSelect.value = petNameInput.value;
                petNameInput.readOnly = true;
            }
        }

        // Set pet type select if old value matches predefined options
        const petTypeInput = document.getElementById('pet_type_input');
        const petTypeSelect = document.getElementById('pet_type_select');
        const predefinedTypes = ['Dog', 'Cat', 'Bird', 'Fish', 'Rabbit', 'Hamster'];

        if (petTypeInput.value && predefinedTypes.includes(petTypeInput.value)) {
            petTypeSelect.value = petTypeInput.value;
            petTypeInput.readOnly = true;
        }

        // Trigger vaccination status change if needed
        const vaccinationStatus = document.getElementById('vaccination_status');
        if (vaccinationStatus.value === 'yes') {
            document.getElementById('expiry_date_container').style.display = 'block';
        }
    });
</script>
@endpush
