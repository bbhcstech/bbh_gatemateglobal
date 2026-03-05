@extends('admin.layout.app')

@section('title', 'Add Vehicle')

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

    /* Parking Slot Display */
    .parking-display {
        background: #f0f9ff;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        border: 1px solid var(--primary-light);
        color: var(--primary-dark);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .parking-display i {
        color: var(--primary);
    }

    /* Approval Box */
    .approval-box {
        background: #f0fdf4;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid #bbf7d0;
    }

    .form-check-input {
        width: 1.2rem;
        height: 1.2rem;
        border: 2px solid #cbd5e1;
        border-radius: 6px;
        margin-right: 0.75rem;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--success);
        border-color: var(--success);
    }

    .form-check-label {
        font-weight: 600;
        color: #166534;
        font-size: 0.95rem;
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
                <span>🚗</span>
            </div>
            <div>
                <h1 class="header-title">Add New Vehicle</h1>
                <div class="header-subtitle">
                    <i class="fas fa-circle"></i>
                    <span>Register a new vehicle for society resident</span>
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
                <i class="fas fa-car-side"></i>
                Vehicle Registration Form
            </h5>
        </div>

        <div class="form-section">
            <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data" id="vehicleForm">
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
                                $loggedInResident = \App\Models\Resident::where('user_id', auth()->id())->first();
                            @endphp

                            <input type="text"
                                   class="form-control"
                                   value="{{ auth()->user()->name }}"
                                   readonly>

                            @if($loggedInResident)
                                <input type="hidden" name="resident_id" value="{{ $loggedInResident->id }}">
                            @else
                                <div class="alert alert-warning mt-2">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    You are not registered as a resident. Please contact admin.
                                </div>
                            @endif
                        @endif

                        @error('resident_id')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Vehicle Number - Mandatory -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-hashtag"></i>
                            Vehicle Number
                            <span class="mandatory-badge">Required</span>
                        </label>
                        <input type="text"
                               name="vehicle_number"
                               class="form-control @error('vehicle_number') is-invalid @enderror"
                               value="{{ old('vehicle_number') }}"
                               placeholder="e.g., WB02AB1234"
                               required>
                        @error('vehicle_number')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Vehicle Type - Mandatory -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-motorcycle"></i>
                            Vehicle Type
                            <span class="mandatory-badge">Required</span>
                        </label>
                        <div class="combo-wrapper">
                            <div class="combo-field">
                                <select id="vehicle_type_select" class="form-select" onchange="updateVehicleType()">
                                    <option value="">Select Type</option>
                                    <option value="Motor Bike" {{ old('vehicle_type') == 'Motor Bike' ? 'selected' : '' }}>Motor Bike</option>
                                    <option value="Bicycle" {{ old('vehicle_type') == 'Bicycle' ? 'selected' : '' }}>Bicycle</option>
                                    <option value="Car" {{ old('vehicle_type') == 'Car' ? 'selected' : '' }}>Car</option>
                                    <option value="Other">Other (Specify)</option>
                                </select>
                            </div>
                            <div class="combo-field">
                                <input type="text"
                                       id="vehicle_type_input"
                                       name="vehicle_type"
                                       class="form-control @error('vehicle_type') is-invalid @enderror"
                                       value="{{ old('vehicle_type') }}"
                                       placeholder="Enter vehicle type"
                                       required>
                            </div>
                        </div>
                        @error('vehicle_type')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Parking Slot - Mandatory -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-parking"></i>
                            Parking Slot
                            <span class="mandatory-badge">Required</span>
                        </label>
                        <div class="combo-wrapper">
                            <div class="combo-field">
                                <select name="parking_slot_id" class="form-select @error('parking_slot_id') is-invalid @enderror" required>
                                    <option value="">Select Parking Slot</option>
                                    @foreach($parkingSlots as $slot)
                                        <option value="{{ $slot->id }}"
                                            {{ old('parking_slot_id') == $slot->id ? 'selected' : '' }}
                                            data-parking-no="{{ $slot->parking_no }}"
                                            data-type="{{ $slot->type }}">
                                            {{ $slot->parking_no }} - {{ $slot->type }}
                                            (Tower: {{ $slot->tower_id }}, Floor: {{ $slot->floor_id }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="combo-field">
                                <div id="parking_slot_display" class="parking-display">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Select a parking slot to see details</span>
                                </div>
                            </div>
                        </div>
                        @error('parking_slot_id')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Vehicle Image - Mandatory -->
                    <div class="col-12">
                        <label class="form-label">
                            <i class="fas fa-camera"></i>
                            Vehicle Image
                            <span class="mandatory-badge">Required</span>
                        </label>
                        <div class="upload-container">
                            <div class="image-upload-area" onclick="document.getElementById('vehicle_image').click()">
                                <div class="image-upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="image-upload-text">
                                    Click to upload vehicle image
                                </div>
                                <div class="image-upload-subtext">
                                    JPG, PNG up to 5MB
                                </div>
                            </div>

                            <input type="file"
                                   id="vehicle_image"
                                   name="vehicle_image"
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

                            @error('vehicle_image')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-times-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Optional Fields Section -->
                <div class="section-title mt-5">
                    <i class="fas fa-info-circle"></i>
                    Additional Information (Optional)
                </div>

                <div class="row g-4">
                    <!-- Sticker Number -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-tag"></i>
                            Sticker Number
                            <span class="optional-badge">Optional</span>
                        </label>
                        <input type="text"
                               name="sticker_number"
                               class="form-control @error('sticker_number') is-invalid @enderror"
                               value="{{ old('sticker_number') }}"
                               placeholder="e.g., STK001">
                        @error('sticker_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Make -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-industry"></i>
                            Make
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="combo-wrapper">
                            <div class="combo-field">
                                <select id="make_select" class="form-select" onchange="updateMake()">
                                    <option value="">Select Make</option>
                                    <option value="Toyota" {{ old('make') == 'Toyota' ? 'selected' : '' }}>Toyota</option>
                                    <option value="Honda" {{ old('make') == 'Honda' ? 'selected' : '' }}>Honda</option>
                                    <option value="Hyundai" {{ old('make') == 'Hyundai' ? 'selected' : '' }}>Hyundai</option>
                                    <option value="Maruti" {{ old('make') == 'Maruti' ? 'selected' : '' }}>Maruti</option>
                                    <option value="Tata" {{ old('make') == 'Tata' ? 'selected' : '' }}>Tata</option>
                                    <option value="Mahindra" {{ old('make') == 'Mahindra' ? 'selected' : '' }}>Mahindra</option>
                                    <option value="Other">Other (Specify)</option>
                                </select>
                            </div>
                            <div class="combo-field">
                                <input type="text"
                                       id="make_input"
                                       name="make"
                                       class="form-control @error('make') is-invalid @enderror"
                                       value="{{ old('make') }}"
                                       placeholder="Enter make name">
                            </div>
                        </div>
                        @error('make')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Model -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-car"></i>
                            Model
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="combo-wrapper">
                            <div class="combo-field">
                                <select id="model_select" class="form-select" onchange="updateModel()">
                                    <option value="">Select Model</option>
                                    <option value="Camry" {{ old('model') == 'Camry' ? 'selected' : '' }}>Camry</option>
                                    <option value="Corolla" {{ old('model') == 'Corolla' ? 'selected' : '' }}>Corolla</option>
                                    <option value="Civic" {{ old('model') == 'Civic' ? 'selected' : '' }}>Civic</option>
                                    <option value="City" {{ old('model') == 'City' ? 'selected' : '' }}>City</option>
                                    <option value="i10" {{ old('model') == 'i10' ? 'selected' : '' }}>i10</option>
                                    <option value="i20" {{ old('model') == 'i20' ? 'selected' : '' }}>i20</option>
                                    <option value="Swift" {{ old('model') == 'Swift' ? 'selected' : '' }}>Swift</option>
                                    <option value="Other">Other (Specify)</option>
                                </select>
                            </div>
                            <div class="combo-field">
                                <input type="text"
                                       id="model_input"
                                       name="model"
                                       class="form-control @error('model') is-invalid @enderror"
                                       value="{{ old('model') }}"
                                       placeholder="Enter model name">
                            </div>
                        </div>
                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-palette"></i>
                            Color
                            <span class="optional-badge">Optional</span>
                        </label>
                        <input type="text"
                               name="color"
                               class="form-control @error('color') is-invalid @enderror"
                               value="{{ old('color') }}"
                               placeholder="e.g., Black, White, Red">
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Admin Approval -->
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="approval-box mt-5">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_approved"
                                   value="1"
                                   id="approvalCheckbox"
                                   {{ old('is_approved', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="approvalCheckbox">
                                <i class="fas fa-check-circle me-2"></i>
                                Approve vehicle for entry
                            </label>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Approved vehicles can enter the society immediately
                        </small>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('vehicles.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Save Vehicle
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
                document.getElementById('vehicle_image').value = '';
                return;
            }

            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                alert('Please upload a valid image file (JPG, PNG)');
                document.getElementById('vehicle_image').value = '';
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
        document.getElementById('vehicle_image').value = '';
        document.getElementById('previewContainer').classList.add('d-none');
        document.querySelector('.image-upload-area').classList.remove('d-none');
    }

    // Vehicle Type handler
    function updateVehicleType() {
        const select = document.getElementById('vehicle_type_select');
        const input = document.getElementById('vehicle_type_input');

        if (select.value === 'Other') {
            input.value = '';
            input.focus();
        } else if (select.value) {
            input.value = select.value;
        }
    }

    // Make handler
    function updateMake() {
        const select = document.getElementById('make_select');
        const input = document.getElementById('make_input');

        if (select.value === 'Other') {
            input.value = '';
            input.focus();
        } else if (select.value) {
            input.value = select.value;
        }
    }

    // Model handler
    function updateModel() {
        const select = document.getElementById('model_select');
        const input = document.getElementById('model_input');

        if (select.value === 'Other') {
            input.value = '';
            input.focus();
        } else if (select.value) {
            input.value = select.value;
        }
    }

    // Parking slot display
    document.querySelector('select[name="parking_slot_id"]').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const displayDiv = document.getElementById('parking_slot_display');

        if (this.value) {
            const parkingNo = selected.getAttribute('data-parking-no');
            const type = selected.getAttribute('data-type');
            displayDiv.innerHTML = `
                <i class="fas fa-check-circle" style="color: #10b981;"></i>
                <span><strong>${parkingNo}</strong> - ${type}</span>
            `;
        } else {
            displayDiv.innerHTML = `
                <i class="fas fa-info-circle"></i>
                <span>Select a parking slot to see details</span>
            `;
        }
    });

    // Form submission loading state
    document.getElementById('vehicleForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        submitBtn.classList.add('loading');
    });

    // Initialize form with old values
    document.addEventListener('DOMContentLoaded', function() {
        // Trigger parking slot display if there's an old value
        const parkingSelect = document.querySelector('select[name="parking_slot_id"]');
        if (parkingSelect.value) {
            parkingSelect.dispatchEvent(new Event('change'));
        }

        // Set vehicle type select if old value matches predefined options
        const vehicleTypeInput = document.getElementById('vehicle_type_input');
        const vehicleTypeSelect = document.getElementById('vehicle_type_select');
        const predefinedTypes = ['Motor Bike', 'Bicycle', 'Car'];

        if (vehicleTypeInput.value && predefinedTypes.includes(vehicleTypeInput.value)) {
            vehicleTypeSelect.value = vehicleTypeInput.value;
        }

        // Set make select if old value matches predefined options
        const makeInput = document.getElementById('make_input');
        const makeSelect = document.getElementById('make_select');
        const predefinedMakes = ['Toyota', 'Honda', 'Hyundai', 'Maruti', 'Tata', 'Mahindra'];

        if (makeInput.value && predefinedMakes.includes(makeInput.value)) {
            makeSelect.value = makeInput.value;
        }

        // Set model select if old value matches predefined options
        const modelInput = document.getElementById('model_input');
        const modelSelect = document.getElementById('model_select');
        const predefinedModels = ['Camry', 'Corolla', 'Civic', 'City', 'i10', 'i20', 'Swift'];

        if (modelInput.value && predefinedModels.includes(modelInput.value)) {
            modelSelect.value = modelInput.value;
        }
    });
</script>
@endpush
