@extends('admin.layout.app')

@section('title', 'Add Family Member')

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

    /* Resident Info Card */
    .resident-info-card {
        background: linear-gradient(135deg, #f0f9ff 0%, #e6f0f9 100%);
        border-radius: 16px;
        padding: 1.25rem;
        border: 1px solid var(--primary-light);
        margin-bottom: 2rem;
    }

    .resident-info-icon {
        width: 48px;
        height: 48px;
        background: var(--primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .resident-info-details {
        color: var(--dark);
    }

    .resident-info-details h6 {
        font-size: 0.75rem;
        color: var(--secondary);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .resident-info-details h4 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .resident-info-details .badge {
        background: var(--primary-light);
        color: var(--primary-dark);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
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

    /* Loading State */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }

    /* Quick Access */
    .quick-actions {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1.5rem;
    }

    .relation-icon {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        margin-right: 0.5rem;
    }

    .relation-icon.father { background: #dbeafe; color: #1e40af; }
    .relation-icon.mother { background: #fce7f3; color: #9d174d; }
    .relation-icon.son { background: #d1fae5; color: #065f46; }
    .relation-icon.daughter { background: #fed7aa; color: #92400e; }
    .relation-icon.spouse { background: #e2e8f0; color: #334155; }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="page-header">
        <div class="d-flex align-items-center">
            <div class="header-icon">
                <span>👥</span>
            </div>
            <div>
                <h1 class="header-title">Add New Family Member</h1>
                <div class="header-subtitle">
                    <i class="fas fa-circle"></i>
                    <span>Add a family member to resident's profile</span>
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
                <i class="fas fa-user-plus"></i>
                Family Member Registration Form
            </h5>
        </div>

        <div class="form-section">
            <form action="{{ route('family-members.store') }}" method="POST" id="familyMemberForm">
                @csrf

                <!-- Resident Information Section -->
                <div class="section-title">
                    <i class="fas fa-home"></i>
                    Resident Information
                </div>

                @if(auth()->user()->role === 'admin' && isset($residents) && !isset($selectedResident))
                    <!-- Admin with resident selection -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-12">
                            <label class="form-label">
                                <i class="fas fa-user-circle"></i>
                                Select Resident
                                <span class="mandatory-badge">Required</span>
                            </label>
                            <select name="resident_id" class="form-select @error('resident_id') is-invalid @enderror" required>
                                <option value="">-- Choose Resident --</option>
                                @foreach($residents as $resident)
                                    <option value="{{ $resident->id }}" {{ old('resident_id') == $resident->id ? 'selected' : '' }}>
                                        {{ $resident->name }} - Flat {{ $resident->flat_no ?? 'N/A' }} ({{ ucfirst($resident->type) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('resident_id')
                                <div class="invalid-feedback">
                                    <i class="fas fa-times-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-info-circle me-1"></i>
                                Select the resident who this family member belongs to
                            </small>
                        </div>
                    </div>
                @elseif(isset($selectedResident))
                    <!-- Admin with pre-selected resident OR Resident adding to their own family -->
                    <input type="hidden" name="resident_id" value="{{ $selectedResident->id }}">

                    <div class="resident-info-card">
                        <div class="d-flex align-items-center">
                            <div class="resident-info-icon me-3">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="resident-info-details flex-grow-1">
                                <h6>Adding family member for</h6>
                                <h4>{{ $selectedResident->name }}</h4>
                                <div class="d-flex gap-3 mt-2">
                                    <span class="badge">
                                        <i class="fas fa-home me-1"></i> Flat: {{ $selectedResident->flat_no ?? 'N/A' }}
                                    </span>
                                    <span class="badge">
                                        <i class="fas fa-tag me-1"></i> ID: #{{ $selectedResident->id }}
                                    </span>
                                    <span class="badge">
                                        <i class="fas fa-user-tag me-1"></i> {{ ucfirst($selectedResident->type) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Member Details Section -->
                <div class="section-title mt-4">
                    <i class="fas fa-user"></i>
                    Member Details
                </div>

                <div class="row g-4">
                    <!-- Member Name - Mandatory -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-user"></i>
                            Full Name
                            <span class="mandatory-badge">Required</span>
                        </label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Enter member's full name"
                               required>
                        @error('name')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Relation - Mandatory -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-heart" style="color: var(--danger);"></i>
                            Relationship
                            <span class="mandatory-badge">Required</span>
                        </label>
                        <div class="combo-wrapper">
                            <div class="combo-field">
                                <select id="relation_select" class="form-select" onchange="updateRelation()">
                                    <option value="">Select Relation</option>
                                    <option value="Father" {{ old('relation_name') == 'Father' ? 'selected' : '' }}>Father</option>
                                    <option value="Mother" {{ old('relation_name') == 'Mother' ? 'selected' : '' }}>Mother</option>
                                    <option value="Son" {{ old('relation_name') == 'Son' ? 'selected' : '' }}>Son</option>
                                    <option value="Daughter" {{ old('relation_name') == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                    <option value="Spouse" {{ old('relation_name') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                    <option value="Brother" {{ old('relation_name') == 'Brother' ? 'selected' : '' }}>Brother</option>
                                    <option value="Sister" {{ old('relation_name') == 'Sister' ? 'selected' : '' }}>Sister</option>
                                    <option value="Grandfather" {{ old('relation_name') == 'Grandfather' ? 'selected' : '' }}>Grandfather</option>
                                    <option value="Grandmother" {{ old('relation_name') == 'Grandmother' ? 'selected' : '' }}>Grandmother</option>
                                    <option value="Other">Other (Specify)</option>
                                </select>
                            </div>
                            <div class="combo-field">
                                <input type="text"
                                       id="relation_input"
                                       name="relation_name"
                                       class="form-control @error('relation_name') is-invalid @enderror"
                                       value="{{ old('relation_name') }}"
                                       placeholder="Enter relationship">
                                <input type="hidden" name="relation_id" id="relation_id" value="{{ old('relation_id') }}">
                            </div>
                        </div>
                        @error('relation_name')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        @error('relation_id')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Select or type the relationship
                        </small>
                    </div>

                    <!-- Mobile Number - Optional -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-phone-alt" style="color: var(--success);"></i>
                            Mobile Number
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">+91</span>
                            <input type="tel"
                                   name="mobile"
                                   class="form-control @error('mobile') is-invalid @enderror"
                                   value="{{ old('mobile') }}"
                                   placeholder="9876543210"
                                   maxlength="10"
                                   pattern="[0-9]{10}">
                        </div>
                        @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            10-digit mobile number (recommended for gate access)
                        </small>
                    </div>

                    <!-- Activity Status -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-toggle-on" style="color: var(--primary);"></i>
                            Activity Status
                        </label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="activity_status" id="activity_status" value="1" {{ old('activity_status', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activity_status">Active</label>
                        </div>
                        <small class="text-muted d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            Inactive members won't have gate access
                        </small>
                    </div>
                </div>

                <!-- Additional Options Section -->
                <div class="section-title mt-5">
                    <i class="fas fa-cog"></i>
                    Additional Options
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="send_notification" name="send_notification" value="1" {{ old('send_notification') ? 'checked' : '' }}>
                            <label class="form-check-label fw-500" for="send_notification">
                                <i class="fas fa-bell text-warning me-2"></i>
                                Send notification to resident
                            </label>
                            <small class="text-muted d-block mt-1">
                                Notify the resident about new family member addition
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="generate_qr" name="generate_qr" value="1" {{ old('generate_qr') ? 'checked' : '' }}>
                            <label class="form-check-label fw-500" for="generate_qr">
                                <i class="fas fa-qrcode text-info me-2"></i>
                                Generate QR code for gate pass
                            </label>
                            <small class="text-muted d-block mt-1">
                                Create QR code for automated gate entry
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Quick Access Preview -->
                <div class="quick-actions">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-magic text-primary me-2"></i>
                        <span class="fw-600">Quick Preview</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="relation-icon preview-relation bg-light">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Preview</small>
                                    <span id="preview_name" class="fw-600">Member Name</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="relation-icon preview-relation-icon bg-light">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Relationship</small>
                                    <span id="preview_relation" class="fw-600">Not selected</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('family-members.index', isset($selectedResident) ? ['resident_id' => $selectedResident->id] : []) }}" class="btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Save Family Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Relation handler
    function updateRelation() {
        const select = document.getElementById('relation_select');
        const input = document.getElementById('relation_input');
        const previewRelation = document.getElementById('preview_relation');
        const previewIcon = document.querySelector('.preview-relation-icon');

        // Set relation classes for preview
        const relationClasses = {
            'Father': 'father',
            'Mother': 'mother',
            'Son': 'son',
            'Daughter': 'daughter',
            'Spouse': 'spouse',
            'Brother': 'son',
            'Sister': 'daughter',
            'Grandfather': 'father',
            'Grandmother': 'mother'
        };

        if (select.value === 'Other') {
            input.value = '';
            input.readOnly = false;
            input.focus();
            if (previewRelation) previewRelation.textContent = 'Other (specify)';
            if (previewIcon) {
                previewIcon.className = 'relation-icon preview-relation-icon bg-light';
                previewIcon.innerHTML = '<i class="fas fa-user"></i>';
            }
        } else if (select.value) {
            input.value = select.value;
            input.readOnly = true;
            if (previewRelation) previewRelation.textContent = select.value;

            // Update preview icon based on relation
            if (previewIcon) {
                const relationClass = relationClasses[select.value] || 'other';
                previewIcon.className = `relation-icon preview-relation-icon ${relationClass}`;

                // Set icon based on relation
                if (['Father', 'Son', 'Brother', 'Grandfather'].includes(select.value)) {
                    previewIcon.innerHTML = '<i class="fas fa-male"></i>';
                } else if (['Mother', 'Daughter', 'Sister', 'Grandmother'].includes(select.value)) {
                    previewIcon.innerHTML = '<i class="fas fa-female"></i>';
                } else if (select.value === 'Spouse') {
                    previewIcon.innerHTML = '<i class="fas fa-heart"></i>';
                } else {
                    previewIcon.innerHTML = '<i class="fas fa-user"></i>';
                }
            }
        } else {
            input.value = '';
            input.readOnly = false;
            if (previewRelation) previewRelation.textContent = 'Not selected';
            if (previewIcon) {
                previewIcon.className = 'relation-icon preview-relation-icon bg-light';
                previewIcon.innerHTML = '<i class="fas fa-user"></i>';
            }
        }
    }

    // Preview name as user types
    document.querySelector('[name="name"]').addEventListener('input', function(e) {
        const preview = document.getElementById('preview_name');
        if (preview) {
            preview.textContent = this.value || 'Member Name';
        }
    });

    // Mobile number validation
    document.querySelector('[name="mobile"]').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });

    // Initialize preview
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.querySelector('[name="name"]');
        if (nameInput && nameInput.value) {
            document.getElementById('preview_name').textContent = nameInput.value;
        }

        const relationSelect = document.getElementById('relation_select');
        const relationInput = document.getElementById('relation_input');

        // Set relation select if old value matches predefined options
        if (relationInput && relationInput.value) {
            const options = Array.from(relationSelect.options);
            const matchingOption = options.find(opt => opt.value === relationInput.value);
            if (matchingOption) {
                relationSelect.value = relationInput.value;
                relationInput.readOnly = true;
                updateRelation();
            }
        }
    });

    // Form submission loading state
    document.getElementById('familyMemberForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        submitBtn.classList.add('loading');
    });

    // Validate form before submit
    document.getElementById('familyMemberForm').addEventListener('submit', function(e) {
        const name = this.querySelector('[name="name"]').value.trim();
        const relation = document.getElementById('relation_input').value.trim();

        if (name.length < 2) {
            e.preventDefault();
            alert('Name must be at least 2 characters long');
            return false;
        }

        if (!relation) {
            e.preventDefault();
            alert('Please select or specify a relationship');
            return false;
        }
    });
</script>
@endpush
