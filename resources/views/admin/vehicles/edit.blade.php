@extends('admin.layout.app')

@section('title', 'Edit Vehicle')

@section('content')
<style>
    /* Clean Bootstrap-based styling */
    :root {
        --primary: #0d6efd;
        --primary-dark: #0b5ed7;
        --primary-light: #e7f1ff;
        --secondary: #6c757d;
        --success: #198754;
        --danger: #dc3545;
        --warning: #ffc107;
        --info: #0dcaf0;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 20px 25px;
        border-radius: 10px;
        margin-bottom: 25px;
        color: white;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    .breadcrumb-custom {
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 20px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: white;
    }

    .breadcrumb-custom a {
        color: white;
        text-decoration: none;
        opacity: 0.9;
    }

    .breadcrumb-custom a:hover {
        opacity: 1;
        text-decoration: underline;
    }

    .form-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        background: white;
    }

    .card-header-custom {
        background: white;
        padding: 18px 25px;
        border-bottom: 2px solid var(--primary);
        border-radius: 12px 12px 0 0 !important;
    }

    .card-header-custom h5 {
        color: var(--primary);
        font-weight: 600;
        margin: 0;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label {
        color: #495057;
        font-weight: 500;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }

    .form-label i {
        color: var(--primary);
        margin-right: 5px;
    }

    .required-star {
        color: var(--danger);
        margin-left: 3px;
    }

    .form-control, .form-select {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
    }

    .form-control:hover, .form-select:hover {
        border-color: var(--primary);
    }

    .image-upload-wrapper {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.2s;
        cursor: pointer;
    }

    .image-upload-wrapper:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }

    .image-upload-icon {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 8px;
    }

    .image-upload-text {
        color: #495057;
        font-weight: 500;
    }

    .image-upload-subtext {
        color: #6c757d;
        font-size: 0.8rem;
        margin-top: 5px;
    }

    .preview-image {
        border-radius: 8px;
        max-height: 120px;
        border: 2px solid #dee2e6;
        padding: 2px;
    }

    .current-image-badge {
        background: var(--primary-light);
        color: var(--primary);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 10px;
    }

    .remove-image-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background: var(--danger);
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.8rem;
    }

    .image-preview-container {
        position: relative;
        display: inline-block;
        margin-top: 10px;
    }

    .status-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        border: 1px solid #dee2e6;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-active {
        background: #d1e7dd;
        color: #0f5132;
    }

    .status-inactive {
        background: #f8d7da;
        color: #842029;
    }

    .btn-update {
        background: var(--primary);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-update:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .btn-cancel {
        background: white;
        color: var(--secondary);
        border: 1px solid #dee2e6;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background: #f8f9fa;
        border-color: var(--danger);
        color: var(--danger);
    }

    .alert-danger {
        background: #f8d7da;
        border: none;
        border-left: 4px solid var(--danger);
        border-radius: 8px;
        color: #842029;
        padding: 15px 20px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d1e7dd;
        border: none;
        border-left: 4px solid var(--success);
        border-radius: 8px;
        color: #0f5132;
        padding: 15px 20px;
        margin-bottom: 20px;
    }

    .invalid-feedback {
        background: #f8d7da;
        color: #842029;
        padding: 5px 12px;
        border-radius: 6px;
        margin-top: 5px;
        font-size: 0.85rem;
        border-left: 3px solid var(--danger);
    }

    .is-invalid {
        border-color: var(--danger) !important;
    }

    .row {
        margin-bottom: 20px;
    }

    hr {
        margin: 25px 0;
        opacity: 0.2;
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1">Edit Vehicle</h3>
            <p class="mb-0 opacity-75">Update vehicle information</p>
        </div>
        <div class="breadcrumb-custom">
            <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
            <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i>
            <a href="{{ route('vehicles.index') }}">Vehicles</a>
            <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i>
            <span>Edit</span>
        </div>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="alert-danger">
            <strong class="d-block mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</strong>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Success Alert -->
    @if (session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <div class="card-header-custom">
            <h5>
                <i class="fas fa-car"></i>
                Vehicle Details
            </h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('vehicles.update', $vehicle->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <h6 class="fw-bold mb-3" style="color: var(--primary);">
                    <i class="fas fa-info-circle me-2"></i>Basic Information
                </h6>

                <div class="row">
                    <!-- Owner -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-user"></i>
                            Owner Name <span class="required-star">*</span>
                        </label>
                        @if(auth()->user()->role === 'admin')
                            <select name="resident_id" class="form-select @error('resident_id') is-invalid @enderror" required>
                                <option value="">Select Owner</option>
                                @foreach($residents as $resident)
                                    <option value="{{ $resident->id }}"
                                        {{ old('resident_id', $vehicle->resident_id) == $resident->id ? 'selected' : '' }}>
                                        {{ $resident->name }} @if($resident->flat) (Flat: {{ $resident->flat->flat_no }}) @endif
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                            <input type="hidden" name="resident_id" value="{{ $vehicle->resident_id }}">
                        @endif
                        @error('resident_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Vehicle Number -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-hashtag"></i>
                            Vehicle Number <span class="required-star">*</span>
                        </label>
                        <input type="text"
                               name="vehicle_number"
                               class="form-control @error('vehicle_number') is-invalid @enderror"
                               value="{{ old('vehicle_number', $vehicle->vehicle_number) }}"
                               placeholder="WB02AB1234"
                               required>
                        @error('vehicle_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Vehicle Details -->
                <h6 class="fw-bold mb-3 mt-3" style="color: var(--primary);">
                    <i class="fas fa-cog me-2"></i>Vehicle Details
                </h6>

                <div class="row">
                    <!-- Vehicle Type -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            <i class="fas fa-motorcycle"></i>
                            Vehicle Type <span class="required-star">*</span>
                        </label>
                        <select name="vehicle_type" class="form-select @error('vehicle_type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            <option value="Motor Bike" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Motor Bike' ? 'selected' : '' }}>Motor Bike</option>
                            <option value="Bicycle" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Bicycle' ? 'selected' : '' }}>Bicycle</option>
                            <option value="Car" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Car' ? 'selected' : '' }}>Car</option>
                            <option value="SUV" {{ old('vehicle_type', $vehicle->vehicle_type) == 'SUV' ? 'selected' : '' }}>SUV</option>
                            <option value="Other" {{ !in_array(old('vehicle_type', $vehicle->vehicle_type), ['Motor Bike', 'Bicycle', 'Car', 'SUV']) ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('vehicle_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Make -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            <i class="fas fa-industry"></i>
                            Make
                        </label>
                        <input type="text"
                               name="make"
                               class="form-control @error('make') is-invalid @enderror"
                               value="{{ old('make', $vehicle->make) }}"
                               placeholder="Toyota, Honda, etc.">
                        @error('make')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Model -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            <i class="fas fa-car"></i>
                            Model
                        </label>
                        <input type="text"
                               name="model"
                               class="form-control @error('model') is-invalid @enderror"
                               value="{{ old('model', $vehicle->model) }}"
                               placeholder="Camry, Civic, etc.">
                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            <i class="fas fa-palette"></i>
                            Color
                        </label>
                        <input type="text"
                               name="color"
                               class="form-control @error('color') is-invalid @enderror"
                               value="{{ old('color', $vehicle->color) }}"
                               placeholder="Black, White, Red">
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sticker Number -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            <i class="fas fa-tag"></i>
                            Sticker Number
                        </label>
                        <input type="text"
                               name="sticker_number"
                               class="form-control @error('sticker_number') is-invalid @enderror"
                               value="{{ old('sticker_number', $vehicle->sticker_number) }}"
                               placeholder="STK001">
                        @error('sticker_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Parking Slot -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            <i class="fas fa-parking"></i>
                            Parking Slot
                        </label>
                        <select name="parking_slot_id" class="form-select @error('parking_slot_id') is-invalid @enderror">
                            <option value="">Select Parking Slot</option>
                            @foreach($parkingSlots as $slot)
                                <option value="{{ $slot->id }}"
                                    {{ old('parking_slot_id', $vehicle->parking_slot_id) == $slot->id ? 'selected' : '' }}>
                                    {{ $slot->parking_no }} - {{ $slot->type ?? 'Regular' }}
                                </option>
                            @endforeach
                        </select>
                        @error('parking_slot_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Image Upload -->
                <h6 class="fw-bold mb-3 mt-3" style="color: var(--primary);">
                    <i class="fas fa-image me-2"></i>Vehicle Image
                </h6>

                <div class="row">
                    <div class="col-md-6">
                        <!-- Current Image Preview -->
                        @if($vehicle->vehicle_image && file_exists(public_path($vehicle->vehicle_image)))
                            <div class="current-image-badge">
                                <i class="fas fa-check-circle"></i> Current Image
                            </div>
                            <div class="image-preview-container mb-3" id="currentImageContainer">
                                <img src="{{ asset($vehicle->vehicle_image) }}"
                                     class="preview-image"
                                     style="max-height: 150px;">
                            </div>
                        @endif

                        <!-- Upload New Image -->
                        <div class="image-upload-wrapper" onclick="document.getElementById('vehicle_image').click()">
                            <div class="image-upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="image-upload-text">
                                Click to upload new image
                            </div>
                            <div class="image-upload-subtext">
                                JPG, PNG (Max 5MB)
                            </div>
                        </div>

                        <input type="file"
                               id="vehicle_image"
                               name="vehicle_image"
                               class="d-none"
                               accept="image/*"
                               onchange="previewImage(event)">

                        <!-- New Image Preview -->
                        <div id="previewContainer" class="text-center mt-3 d-none">
                            <div class="image-preview-container">
                                <img id="imagePreview" class="preview-image">
                                <button type="button" class="remove-image-btn" onclick="removeImage()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        @error('vehicle_image')
                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>

                <!-- Status Section -->
                <div class="status-section">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-2">
                                <i class="fas fa-shield-alt me-2" style="color: var(--primary);"></i>
                                Vehicle Status
                            </label>
                            <select name="status" class="form-select">
                                <option value="active" {{ old('status', $vehicle->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $vehicle->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                               
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-3 mt-md-0">
                                <span class="text-muted me-2">Current:</span>
                                @php
                                    $statusClass = match($vehicle->status) {
                                        'active', 'approved' => 'status-active',
                                        default => 'status-inactive'
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    <i class="fas fa-{{ $vehicle->status == 'active' ? 'check-circle' : 'minus-circle' }}"></i>
                                    {{ ucfirst($vehicle->status ?? 'pending') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('vehicles.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-update">
                        <i class="fas fa-save me-2"></i>
                        Update Vehicle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('imagePreview');
                img.src = e.target.result;
                document.getElementById('previewContainer').classList.remove('d-none');

                const currentImage = document.getElementById('currentImageContainer');
                if (currentImage) {
                    currentImage.style.display = 'none';
                }
            }
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        document.getElementById('vehicle_image').value = '';
        document.getElementById('previewContainer').classList.add('d-none');

        const currentImage = document.getElementById('currentImageContainer');
        if (currentImage) {
            currentImage.style.display = 'block';
        }
    }
</script>
@endpush
