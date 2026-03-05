@extends('admin.layout.app')

@section('title', 'Edit Vehicle')

@section('content')
<style>
    /* Purple & White Theme - Same as Create Page */
    :root {
        --primary-purple: #8B5CF6;
        --primary-purple-dark: #7C3AED;
        --primary-purple-light: #EDE9FE;
        --secondary-purple: #A78BFA;
        --gradient-purple: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    }

    /* Page Header */
    .page-header {
        background: var(--gradient-purple);
        padding: 25px 30px;
        border-radius: 20px;
        margin-bottom: 30px;
        color: white;
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.3);
        animation: slideDown 0.5s ease-out;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Breadcrumb */
    .breadcrumb-custom {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 12px 25px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: white;
        margin-bottom: 0;
    }

    .breadcrumb-custom a {
        color: white;
        text-decoration: none;
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .breadcrumb-custom a:hover {
        opacity: 1;
        transform: translateX(2px);
    }

    .breadcrumb-custom i {
        font-size: 0.8rem;
        opacity: 0.6;
    }

    /* Form Card */
    .form-card {
        border: none;
        border-radius: 25px;
        box-shadow: 0 20px 60px rgba(139, 92, 246, 0.15);
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out;
        background: white;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card Header */
    .card-header-custom {
        background: white;
        padding: 22px 30px;
        border-bottom: 3px solid var(--primary-purple);
        position: relative;
    }

    .card-header-custom::before {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 100px;
        height: 3px;
        background: var(--gradient-purple);
        animation: slide 2s infinite;
    }

    @keyframes slide {
        0% { left: 0; width: 100px; }
        50% { left: 50%; width: 200px; transform: translateX(-50%); }
        100% { left: calc(100% - 100px); width: 100px; }
    }

    .card-header-custom h5 {
        background: var(--gradient-purple);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 700;
        margin: 0;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Form Labels */
    .form-label {
        color: #4B5563;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-label i {
        color: var(--primary-purple);
        margin-right: 5px;
    }

    .required-star {
        color: #EF4444;
        margin-left: 3px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    /* Input Fields */
    .form-control, .form-select {
        border: 2px solid #E5E7EB;
        border-radius: 15px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #F9FAFB;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-purple);
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
        background: white;
        transform: translateY(-2px);
    }

    .form-control:hover, .form-select:hover {
        border-color: var(--secondary-purple);
        background: white;
    }

    /* Input Wrapper Animation */
    .input-wrapper {
        animation: floatIn 0.5s ease-out forwards;
        opacity: 0;
    }

    @keyframes floatIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Stagger animations */
    .input-wrapper:nth-child(1) { animation-delay: 0.1s; }
    .input-wrapper:nth-child(2) { animation-delay: 0.15s; }
    .input-wrapper:nth-child(3) { animation-delay: 0.2s; }
    .input-wrapper:nth-child(4) { animation-delay: 0.25s; }
    .input-wrapper:nth-child(5) { animation-delay: 0.3s; }
    .input-wrapper:nth-child(6) { animation-delay: 0.35s; }
    .input-wrapper:nth-child(7) { animation-delay: 0.4s; }
    .input-wrapper:nth-child(8) { animation-delay: 0.45s; }
    .input-wrapper:nth-child(9) { animation-delay: 0.5s; }
    .input-wrapper:nth-child(10) { animation-delay: 0.55s; }

    /* Combo Field (Dropdown + Text) */
    .combo-field {
        margin-bottom: 10px;
    }

    .combo-field:last-child {
        margin-bottom: 0;
    }

    /* Image Upload Area */
    .image-upload-wrapper {
        border: 3px dashed var(--primary-purple-light);
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        background: linear-gradient(135deg, #F5F3FF 0%, #ffffff 100%);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .image-upload-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.5s ease;
    }

    .image-upload-wrapper:hover::before {
        left: 100%;
    }

    .image-upload-wrapper:hover {
        border-color: var(--primary-purple);
        background: var(--primary-purple-light);
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(139, 92, 246, 0.2);
    }

    .image-upload-icon {
        font-size: 2.5rem;
        color: var(--primary-purple);
        margin-bottom: 10px;
    }

    .image-upload-text {
        color: #4B5563;
        font-weight: 500;
    }

    .image-upload-subtext {
        color: #9CA3AF;
        font-size: 0.85rem;
        margin-top: 5px;
    }

    /* Image Preview */
    .image-preview-container {
        position: relative;
        display: inline-block;
        margin-top: 15px;
        animation: zoomIn 0.5s ease-out;
    }

    @keyframes zoomIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .preview-image {
        border-radius: 15px;
        max-height: 120px;
        border: 4px solid white;
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.2);
    }

    .remove-image-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 28px;
        height: 28px;
        background: #EF4444;
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
    }

    .remove-image-btn:hover {
        transform: scale(1.1) rotate(90deg);
        background: #DC2626;
    }

    /* Checkbox Styling */
    .approval-box {
        background: linear-gradient(135deg, #F5F3FF 0%, #ffffff 100%);
        border-radius: 15px;
        padding: 20px;
        border: 2px solid var(--primary-purple-light);
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        margin-right: 10px;
        border: 2px solid #D1D5DB;
        border-radius: 6px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--primary-purple);
        border-color: var(--primary-purple);
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        transform: scale(1.1);
    }

    .form-check-label {
        font-weight: 600;
        color: #374151;
        cursor: pointer;
    }

    /* Status Badge Styling */
    .status-badge {
        padding: 5px 15px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-approved {
        background: #DEF7EC;
        color: #0E9F6E;
    }

    .status-pending {
        background: #FEF3C7;
        color: #B45309;
    }

    .status-rejected {
        background: #FEE2E2;
        color: #DC2626;
    }

    .status-inactive {
        background: #E5E7EB;
        color: #4B5563;
    }

    .status-blacklisted {
        background: #1F2937;
        color: white;
    }

    /* Buttons */
    .btn-update {
        background: var(--gradient-purple);
        color: white;
        border: none;
        padding: 14px 35px;
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(139, 92, 246, 0.4);
    }

    .btn-update::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-update:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-update:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.6);
    }

    .btn-cancel {
        background: white;
        color: var(--primary-purple);
        border: 2px solid var(--primary-purple);
        padding: 14px 35px;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cancel:hover {
        background: #FEE2E2;
        border-color: #EF4444;
        color: #DC2626;
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(239, 68, 68, 0.2);
    }

    /* Alert Styling */
    .alert-danger {
        background: #FEE2E2;
        border: none;
        border-left: 5px solid #EF4444;
        border-radius: 15px;
        color: #DC2626;
        padding: 20px;
        margin-bottom: 25px;
        animation: slideInRight 0.5s ease-out;
    }

    .alert-success {
        background: #DEF7EC;
        border: none;
        border-left: 5px solid #0E9F6E;
        border-radius: 15px;
        color: #0E9F6E;
        padding: 20px;
        margin-bottom: 25px;
        animation: slideInRight 0.5s ease-out;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .alert-danger ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .alert-danger li {
        padding: 5px 0;
        padding-left: 25px;
        position: relative;
    }

    .alert-danger li::before {
        content: '⚠️';
        position: absolute;
        left: 0;
    }

    .alert-success i {
        margin-right: 10px;
    }

    /* Error Styling */
    .is-invalid {
        border-color: #EF4444 !important;
    }

    .invalid-feedback {
        background: #FEE2E2;
        color: #DC2626;
        padding: 8px 15px;
        border-radius: 10px;
        margin-top: 8px;
        font-size: 0.85rem;
        border-left: 4px solid #EF4444;
        animation: shake 0.3s ease-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* Current Image Badge */
    .current-image-badge {
        background: var(--primary-purple-light);
        color: var(--primary-purple);
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 10px;
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header with Breadcrumb -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <span style="font-size: 2.5rem;">✏️</span>
                </div>
                <div>
                    <h1 class="display-6 fw-bold mb-2">Edit Vehicle</h1>
                    <p class="mb-0 opacity-75">Update vehicle information for society resident</p>
                </div>
            </div>

            <!-- Breadcrumb -->
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('vehicles.index') }}">Vehicles</a>
                <i class="fas fa-chevron-right"></i>
                <span>Edit</span>
            </div>
        </div>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="alert-danger">
            <strong class="d-block mb-2"><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Success Alert -->
    @if (session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <div class="card-header-custom">
            <h5>
                <i class="fas fa-edit"></i>
                Edit Vehicle Details
            </h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('vehicles.update', $vehicle->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Left Column - 8 columns -->
                    <div class="col-lg-8">
                        <div class="row g-4">
                            <!-- Owner Selection -->
                            <div class="col-12 input-wrapper">
                                <label class="form-label">
                                    <i class="fas fa-user"></i>
                                    Owner Name <span class="required-star">*</span>
                                </label>

                                @if(auth()->user()->role === 'admin')
                                    @php
                                        // Find the resident that matches this vehicle's user_id or resident_id
                                        $selectedResidentId = null;
                                        foreach($residents as $resident) {
                                            if($resident->id == $vehicle->resident_id || $resident->user_id == $vehicle->user_id) {
                                                $selectedResidentId = $resident->id;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <select name="resident_id" class="form-select @error('resident_id') is-invalid @enderror" required>
                                        <option value="">Select Owner</option>
                                        @foreach($residents as $resident)
                                            <option value="{{ $resident->id }}"
                                                {{ old('resident_id', $selectedResidentId) == $resident->id ? 'selected' : '' }}>
                                                {{ $resident->name }} - Flat {{ $resident->flat?->flat_no ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text"
                                           class="form-control"
                                           value="{{ auth()->user()->name }}"
                                           readonly>
                                    <input type="hidden"
                                           name="resident_id"
                                           value="{{ old('resident_id', $vehicle->resident_id) }}">
                                @endif

                                @error('resident_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vehicle Number -->
                            <div class="col-md-6 input-wrapper">
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

                            <!-- Sticker Number -->
                            <div class="col-md-6 input-wrapper">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>
                                    Sticker Number <span class="required-star">*</span>
                                </label>
                                <input type="text"
                                       name="sticker_number"
                                       class="form-control @error('sticker_number') is-invalid @enderror"
                                       value="{{ old('sticker_number', $vehicle->sticker_number) }}"
                                       placeholder="STK001"
                                       required>
                                @error('sticker_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vehicle Type - Dropdown + Text -->
                            <div class="col-12 input-wrapper">
                                <label class="form-label">
                                    <i class="fas fa-motorcycle"></i>
                                    Vehicle Type <span class="required-star">*</span>
                                </label>
                                <div class="combo-field">
                                    <select id="vehicle_type_select" class="form-select" onchange="updateVehicleType()">
                                        <option value="">Select Type</option>
                                        <option value="Motor Bike" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Motor Bike' ? 'selected' : '' }}>Motor Bike</option>
                                        <option value="Bicycle" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Bicycle' ? 'selected' : '' }}>Bicycle</option>
                                        <option value="Car" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Car' ? 'selected' : '' }}>Car</option>
                                        <option value="Other">Other (Type below)</option>
                                    </select>
                                </div>
                                <div class="combo-field">
                                    <input type="text"
                                           id="vehicle_type_input"
                                           name="vehicle_type"
                                           class="form-control @error('vehicle_type') is-invalid @enderror"
                                           value="{{ old('vehicle_type', $vehicle->vehicle_type) }}"
                                           placeholder="Enter vehicle type"
                                           required>
                                </div>
                                @error('vehicle_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Make - Dropdown + Text -->
                            <div class="col-md-6 input-wrapper">
                                <label class="form-label">
                                    <i class="fas fa-industry"></i>
                                    Make <span class="required-star">*</span>
                                </label>
                                <div class="combo-field">
                                    <select id="make_select" class="form-select" onchange="updateMake()">
                                        <option value="">Select Make</option>
                                        <option value="Toyota" {{ old('make', $vehicle->make) == 'Toyota' ? 'selected' : '' }}>Toyota</option>
                                        <option value="Honda" {{ old('make', $vehicle->make) == 'Honda' ? 'selected' : '' }}>Honda</option>
                                        <option value="Hyundai" {{ old('make', $vehicle->make) == 'Hyundai' ? 'selected' : '' }}>Hyundai</option>
                                        <option value="Maruti" {{ old('make', $vehicle->make) == 'Maruti' ? 'selected' : '' }}>Maruti</option>
                                        <option value="Tata" {{ old('make', $vehicle->make) == 'Tata' ? 'selected' : '' }}>Tata</option>
                                        <option value="Mahindra" {{ old('make', $vehicle->make) == 'Mahindra' ? 'selected' : '' }}>Mahindra</option>
                                        <option value="Other">Other (Type below)</option>
                                    </select>
                                </div>
                                <div class="combo-field">
                                    <input type="text"
                                           id="make_input"
                                           name="make"
                                           class="form-control @error('make') is-invalid @enderror"
                                           value="{{ old('make', $vehicle->make) }}"
                                           placeholder="Enter make name"
                                           required>
                                </div>
                                @error('make')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Model - Dropdown + Text -->
                            <div class="col-md-6 input-wrapper">
                                <label class="form-label">
                                    <i class="fas fa-car"></i>
                                    Model <span class="required-star">*</span>
                                </label>
                                <div class="combo-field">
                                    <select id="model_select" class="form-select" onchange="updateModel()">
                                        <option value="">Select Model</option>
                                        <option value="Camry" {{ old('model', $vehicle->model) == 'Camry' ? 'selected' : '' }}>Camry</option>
                                        <option value="Corolla" {{ old('model', $vehicle->model) == 'Corolla' ? 'selected' : '' }}>Corolla</option>
                                        <option value="Civic" {{ old('model', $vehicle->model) == 'Civic' ? 'selected' : '' }}>Civic</option>
                                        <option value="City" {{ old('model', $vehicle->model) == 'City' ? 'selected' : '' }}>City</option>
                                        <option value="i10" {{ old('model', $vehicle->model) == 'i10' ? 'selected' : '' }}>i10</option>
                                        <option value="i20" {{ old('model', $vehicle->model) == 'i20' ? 'selected' : '' }}>i20</option>
                                        <option value="Swift" {{ old('model', $vehicle->model) == 'Swift' ? 'selected' : '' }}>Swift</option>
                                        <option value="Other">Other (Type below)</option>
                                    </select>
                                </div>
                                <div class="combo-field">
                                    <input type="text"
                                           id="model_input"
                                           name="model"
                                           class="form-control @error('model') is-invalid @enderror"
                                           value="{{ old('model', $vehicle->model) }}"
                                           placeholder="Enter model name"
                                           required>
                                </div>
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Color -->
                            <div class="col-md-6 input-wrapper">
                                <label class="form-label">
                                    <i class="fas fa-palette"></i>
                                    Color <span class="required-star">*</span>
                                </label>
                                <input type="text"
                                       name="color"
                                       class="form-control @error('color') is-invalid @enderror"
                                       value="{{ old('color', $vehicle->color) }}"
                                       placeholder="Black, White, Red, etc."
                                       required>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Parking Slot - Dropdown from Master Table -->
                            <div class="col-md-6 input-wrapper">
                                <label class="form-label">
                                    <i class="fas fa-parking"></i>
                                    Parking Slot <span class="required-star">*</span>
                                </label>
                                <select name="parking_slot_id" class="form-select @error('parking_slot_id') is-invalid @enderror" required>
                                    <option value="">Select Parking Slot</option>
                                    @if(isset($parkingSlots) && count($parkingSlots) > 0)
                                        @foreach($parkingSlots as $slot)
                                            <option value="{{ $slot->id }}"
                                                {{ old('parking_slot_id', $vehicle->parking_slot_id) == $slot->id ? 'selected' : '' }}>
                                                {{ $slot->parking_no }} - {{ $slot->type ?? 'Regular' }}
                                            </option>
                                        @endforeach
                                    @else
                                        <!-- Fallback options if no parking slots in DB -->
                                        <option value="1" {{ old('parking_slot_id', $vehicle->parking_slot_id) == 1 ? 'selected' : '' }}>A-001 (Regular)</option>
                                        <option value="2" {{ old('parking_slot_id', $vehicle->parking_slot_id) == 2 ? 'selected' : '' }}>A-002 (Regular)</option>
                                        <option value="3" {{ old('parking_slot_id', $vehicle->parking_slot_id) == 3 ? 'selected' : '' }}>B-001 (Covered)</option>
                                        <option value="4" {{ old('parking_slot_id', $vehicle->parking_slot_id) == 4 ? 'selected' : '' }}>B-002 (Covered)</option>
                                        <option value="5" {{ old('parking_slot_id', $vehicle->parking_slot_id) == 5 ? 'selected' : '' }}>C-001 (VIP)</option>
                                    @endif
                                </select>
                                @error('parking_slot_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - 4 columns -->
                    <div class="col-lg-4">
                        <!-- Image Upload -->
                        <div class="input-wrapper">
                            <label class="form-label">
                                <i class="fas fa-camera"></i>
                                Vehicle Image <span class="required-star">*</span>
                            </label>

                            <!-- Current Image Preview -->
                            @if(!empty($vehicle->vehicle_image) && file_exists(public_path($vehicle->vehicle_image)))
                                <div class="current-image-badge">
                                    <i class="fas fa-check-circle"></i> Current Image
                                </div>
                                <div class="image-preview-container" id="currentImageContainer">
                                    <img src="{{ asset($vehicle->vehicle_image) }}"
                                         class="preview-image"
                                         style="max-height: 120px;">
                                </div>
                            @endif

                            <!-- Upload New Image -->
                            <div class="image-upload-wrapper mt-3" onclick="document.getElementById('vehicle_image').click()">
                                <div class="image-upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="image-upload-text">
                                    Click to change image
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
                                   onchange="previewImage(event)">

                            <!-- New Image Preview -->
                            <div id="previewContainer" class="text-center d-none">
                                <div class="image-preview-container">
                                    <img id="imagePreview" class="preview-image">
                                    <button type="button" class="remove-image-btn" onclick="removeImage()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>

                            @error('vehicle_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status Change Section - VISIBLE FOR BOTH ADMIN AND RESIDENT -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card" style="background: linear-gradient(135deg, #F5F3FF 0%, #ffffff 100%); border: 2px solid var(--primary-purple-light); border-radius: 20px; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.1);">
                            <div class="card-body p-4">
                                <h5 class="mb-3" style="color: var(--primary-purple); font-weight: 700;">
                                    <i class="fas fa-shield-alt me-2"></i>Vehicle Status
                                </h5>

                                <div class="row">
                                    <!-- Approval Checkbox (Only for Admin) -->
                                    @if(auth()->check() && auth()->user()->role === 'admin')
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="is_approved"
                                                   value="1"
                                                   id="approvalCheckbox"
                                                   {{ old('is_approved', $vehicle->status == 'approved') ? 'checked' : '' }}
                                                   style="width: 20px; height: 20px; border: 2px solid #D1D5DB; border-radius: 6px; cursor: pointer;">
                                            <label class="form-check-label fw-semibold ms-2" for="approvalCheckbox" style="font-size: 1rem; color: #374151;">
                                                <i class="fas fa-check-circle text-success me-1"></i>
                                                Approved for entry
                                            </label>
                                        </div>
                                        <small class="text-muted d-block mt-2 ms-4">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Approved vehicles can enter the society immediately
                                        </small>
                                    </div>
                                    @endif

                                    <!-- Status Change Dropdown - VISIBLE FOR EVERYONE (Admin & Resident) -->
                                    <div class="col-md-6 {{ auth()->user()->role !== 'admin' ? 'offset-md-3' : '' }}">
                                        <label class="form-label fw-bold mb-2" style="color: #4B5563; font-size: 0.95rem;">
                                            <i class="fas fa-exchange-alt me-1" style="color: var(--primary-purple);"></i>
                                            Change Vehicle Status
                                        </label>
                                        <select name="status" class="form-select" style="border: 2px solid var(--primary-purple-light); border-radius: 15px; padding: 12px 16px; font-size: 1rem; background: white; cursor: pointer;">
                                            <option value="pending" {{ $vehicle->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="approved" {{ $vehicle->status == 'approved' ? 'selected' : '' }}>✅ Approved</option>
                                            <option value="rejected" {{ $vehicle->status == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                                            <option value="inactive" {{ $vehicle->status == 'inactive' ? 'selected' : '' }}>⭕ Inactive</option>
                                            <option value="blacklisted" {{ $vehicle->status == 'blacklisted' ? 'selected' : '' }}>🚫 Blacklisted</option>
                                        </select>

                                        <!-- Current Status Badge -->
                                        <div class="mt-2 d-flex align-items-center">
                                            <small class="text-muted me-2">Current Status:</small>
                                            @php
                                                $status = $vehicle->status ?? 'pending';
                                                $badgeClass = match($status) {
                                                    'approved' => 'bg-success',
                                                    'pending' => 'bg-warning text-dark',
                                                    'rejected' => 'bg-danger',
                                                    'inactive' => 'bg-secondary',
                                                    'blacklisted' => 'bg-dark',
                                                    default => 'bg-warning text-dark'
                                                };
                                                $badgeIcon = match($status) {
                                                    'approved' => '✅',
                                                    'pending' => '⏳',
                                                    'rejected' => '❌',
                                                    'inactive' => '⭕',
                                                    'blacklisted' => '🚫',
                                                    default => '⏳'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} ms-1" style="padding: 8px 15px; border-radius: 30px; font-size: 0.9rem;">
                                                {{ $badgeIcon }} {{ ucfirst($status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="d-flex justify-content-end gap-3 mt-5 pt-4 border-top">
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

                // Hide current image if exists
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

        // Show current image again
        const currentImage = document.getElementById('currentImageContainer');
        if (currentImage) {
            currentImage.style.display = 'block';
        }
    }

    // Vehicle Type dropdown handler
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

    // Make dropdown handler
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

    // Model dropdown handler
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

    // Initialize form with existing values
    document.addEventListener('DOMContentLoaded', function() {
        // Set vehicle type select if current value matches predefined options
        const vehicleTypeInput = document.getElementById('vehicle_type_input');
        const vehicleTypeSelect = document.getElementById('vehicle_type_select');
        const predefinedTypes = ['Motor Bike', 'Bicycle', 'Car'];

        if (vehicleTypeInput.value && predefinedTypes.includes(vehicleTypeInput.value)) {
            vehicleTypeSelect.value = vehicleTypeInput.value;
        }

        // Set make select if current value matches predefined options
        const makeInput = document.getElementById('make_input');
        const makeSelect = document.getElementById('make_select');
        const predefinedMakes = ['Toyota', 'Honda', 'Hyundai', 'Maruti', 'Tata', 'Mahindra'];

        if (makeInput.value && predefinedMakes.includes(makeInput.value)) {
            makeSelect.value = makeInput.value;
        }

        // Set model select if current value matches predefined options
        const modelInput = document.getElementById('model_input');
        const modelSelect = document.getElementById('model_select');
        const predefinedModels = ['Camry', 'Corolla', 'Civic', 'City', 'i10', 'i20', 'Swift'];

        if (modelInput.value && predefinedModels.includes(modelInput.value)) {
            modelSelect.value = modelInput.value;
        }
    });
</script>
@endpush
