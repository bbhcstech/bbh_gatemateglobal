@extends('admin.layout.app')

@section('title', 'Edit Family Member')

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
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
        box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.2);
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
        color: var(--warning);
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
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        padding: 1.5rem 2rem;
        color: white;
    }

    .card-header-custom h5 {
        font-size: 1.25rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
    }

    .card-header-custom h5 i {
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
        color: var(--warning);
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
        color: var(--warning);
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
        border-color: var(--warning);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--warning);
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
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
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 16px;
        padding: 1.25rem;
        border: 1px solid #fbbf24;
        margin-bottom: 2rem;
    }

    .resident-info-icon {
        width: 48px;
        height: 48px;
        background: var(--warning);
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
        color: #92400e;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .resident-info-details h4 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #92400e;
    }

    .resident-info-details .badge {
        background: white;
        color: #92400e;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
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

    /* Audit Card */
    .audit-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 1.25rem;
        border: 1px solid var(--border);
        margin-top: 1.5rem;
    }

    .audit-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .audit-title i {
        color: var(--warning);
    }

    .audit-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .audit-item {
        background: white;
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid var(--border);
    }

    .audit-label {
        font-size: 0.7rem;
        color: var(--secondary);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
    }

    .audit-value {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark);
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
        background: var(--warning);
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
        box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.2);
    }

    .btn-primary:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.3);
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
        text-decoration: none;
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

    /* Quick Preview */
    .quick-preview {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1.5rem;
    }

    .preview-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-icon.father { background: #dbeafe; color: #1e40af; }
    .preview-icon.mother { background: #fce7f3; color: #9d174d; }
    .preview-icon.son { background: #d1fae5; color: #065f46; }
    .preview-icon.daughter { background: #fed7aa; color: #92400e; }
    .preview-icon.spouse { background: #e2e8f0; color: #334155; }

    /* Responsive */
    @media (max-width: 768px) {
        .audit-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="page-header">
        <div class="d-flex align-items-center">
            <div class="header-icon">
                <span>✏️</span>
            </div>
            <div>
                <h1 class="header-title">Edit Family Member</h1>
                <div class="header-subtitle">
                    <i class="fas fa-circle"></i>
                    <span>Update family member information</span>
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
                <i class="fas fa-edit"></i>
                Edit Family Member Details
            </h5>
        </div>

        <div class="form-section">
            <!-- Resident Information Card -->
            <div class="resident-info-card">
                <div class="d-flex align-items-center">
                    <div class="resident-info-icon me-3">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="resident-info-details flex-grow-1">
                        <h6>Resident Information</h6>
                        <h4>{{ $familyMember->resident->name ?? 'N/A' }}</h4>
                        <div class="d-flex gap-3 mt-2">
                            <span class="badge">
                                <i class="fas fa-door-open me-1"></i> Flat: {{ $familyMember->resident->flat_no ?? 'N/A' }}
                            </span>
                            <span class="badge">
                                <i class="fas fa-hashtag me-1"></i> ID: #{{ $familyMember->resident->id ?? 'N/A' }}
                            </span>
                            <span class="badge">
                                <i class="fas fa-user-tag me-1"></i> {{ ucfirst($familyMember->resident->type ?? 'Owner') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('family-members.update', $familyMember) }}" method="POST" id="editForm">
                @csrf
                @method('PUT')

                <!-- Member Details Section -->
                <div class="section-title">
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
                               value="{{ old('name', $familyMember->name) }}"
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
                                    <option value="Father" {{ $familyMember->relation->name == 'Father' ? 'selected' : '' }}>Father</option>
                                    <option value="Mother" {{ $familyMember->relation->name == 'Mother' ? 'selected' : '' }}>Mother</option>
                                    <option value="Son" {{ $familyMember->relation->name == 'Son' ? 'selected' : '' }}>Son</option>
                                    <option value="Daughter" {{ $familyMember->relation->name == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                    <option value="Spouse" {{ $familyMember->relation->name == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                    <option value="Brother" {{ $familyMember->relation->name == 'Brother' ? 'selected' : '' }}>Brother</option>
                                    <option value="Sister" {{ $familyMember->relation->name == 'Sister' ? 'selected' : '' }}>Sister</option>
                                    <option value="Grandfather" {{ $familyMember->relation->name == 'Grandfather' ? 'selected' : '' }}>Grandfather</option>
                                    <option value="Grandmother" {{ $familyMember->relation->name == 'Grandmother' ? 'selected' : '' }}>Grandmother</option>
                                    <option value="Other" {{ !in_array($familyMember->relation->name, ['Father', 'Mother', 'Son', 'Daughter', 'Spouse', 'Brother', 'Sister', 'Grandfather', 'Grandmother']) ? 'selected' : '' }}>Other (Specify)</option>
                                </select>
                            </div>
                            <div class="combo-field">
                                <input type="text"
                                       id="relation_input"
                                       name="relation_name"
                                       class="form-control @error('relation_name') is-invalid @enderror"
                                       value="{{ old('relation_name', $familyMember->relation->name) }}"
                                       placeholder="Enter relationship"
                                       {{ in_array($familyMember->relation->name, ['Father', 'Mother', 'Son', 'Daughter', 'Spouse', 'Brother', 'Sister', 'Grandfather', 'Grandmother']) ? 'readonly' : '' }}>
                                <input type="hidden" name="relation_id" id="relation_id" value="{{ $familyMember->relation_id }}">
                            </div>
                        </div>
                        @error('relation_name')
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
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
                                   value="{{ old('mobile', $familyMember->mobile) }}"
                                   placeholder="9876543210"
                                   maxlength="10"
                                   pattern="[0-9]{10}">
                        </div>
                        @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            10-digit mobile number
                        </small>
                    </div>

                    <!-- Activity Status -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-toggle-on" style="color: var(--warning);"></i>
                            Activity Status
                        </label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="activity_status" id="activity_status" value="1" {{ old('activity_status', $familyMember->activity_status) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activity_status">Active</label>
                        </div>
                        <small class="text-muted d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            Inactive members won't have gate access
                        </small>
                    </div>
                </div>

                <!-- Quick Preview -->
                <div class="quick-preview">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-magic text-warning me-2"></i>
                        <span class="fw-600">Live Preview</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="preview-icon me-2" id="preview_icon">
                                    <i class="fas {{ $familyMember->relation->name == 'Father' || $familyMember->relation->name == 'Son' || $familyMember->relation->name == 'Brother' || $familyMember->relation->name == 'Grandfather' ? 'fa-male' : ($familyMember->relation->name == 'Mother' || $familyMember->relation->name == 'Daughter' || $familyMember->relation->name == 'Sister' || $familyMember->relation->name == 'Grandmother' ? 'fa-female' : 'fa-user') }}"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Member</small>
                                    <span id="preview_name" class="fw-600">{{ $familyMember->name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="preview-icon me-2" id="preview_relation_icon" style="background: {{ $familyMember->relation->name == 'Father' ? '#dbeafe' : ($familyMember->relation->name == 'Mother' ? '#fce7f3' : ($familyMember->relation->name == 'Son' ? '#d1fae5' : ($familyMember->relation->name == 'Daughter' ? '#fed7aa' : '#e2e8f0'))) }};">
                                    <i class="fas {{ $familyMember->relation->name == 'Father' || $familyMember->relation->name == 'Son' || $familyMember->relation->name == 'Brother' || $familyMember->relation->name == 'Grandfather' ? 'fa-male' : ($familyMember->relation->name == 'Mother' || $familyMember->relation->name == 'Daughter' || $familyMember->relation->name == 'Sister' || $familyMember->relation->name == 'Grandmother' ? 'fa-female' : 'fa-heart') }}"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Relationship</small>
                                    <span id="preview_relation" class="fw-600">{{ $familyMember->relation->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Audit Trail Information -->
                <div class="audit-card">
                    <div class="audit-title">
                        <i class="fas fa-history"></i>
                        Audit Information
                    </div>
                    <div class="audit-grid">
                        <div class="audit-item">
                            <div class="audit-label">Created By</div>
                            <div class="audit-value">
                                @if($familyMember->creator)
                                    {{ $familyMember->creator->name ?? 'System' }}
                                @else
                                    System
                                @endif
                            </div>
                        </div>
                        <div class="audit-item">
                            <div class="audit-label">Created At</div>
                            <div class="audit-value">
                                {{ $familyMember->created_at ? $familyMember->created_at->format('d M Y, h:i A') : 'N/A' }}
                            </div>
                        </div>
                        <div class="audit-item">
                            <div class="audit-label">Last Updated By</div>
                            <div class="audit-value">
                                @if($familyMember->updater)
                                    {{ $familyMember->updater->name ?? 'System' }}
                                @else
                                    System
                                @endif
                            </div>
                        </div>
                        <div class="audit-item">
                            <div class="audit-label">Last Updated At</div>
                            <div class="audit-value">
                                {{ $familyMember->updated_at ? $familyMember->updated_at->format('d M Y, h:i A') : 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('family-members.index', ['resident_id' => $familyMember->resident_id]) }}" class="btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Update Family Member
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
        const previewIcon = document.getElementById('preview_relation_icon');
        const previewIconMain = document.getElementById('preview_icon');

        // Set relation classes for preview
        const relationClasses = {
            'Father': { class: 'father', icon: 'fa-male', color: '#dbeafe' },
            'Mother': { class: 'mother', icon: 'fa-female', color: '#fce7f3' },
            'Son': { class: 'son', icon: 'fa-male', color: '#d1fae5' },
            'Daughter': { class: 'daughter', icon: 'fa-female', color: '#fed7aa' },
            'Spouse': { class: 'spouse', icon: 'fa-heart', color: '#e2e8f0' },
            'Brother': { class: 'son', icon: 'fa-male', color: '#d1fae5' },
            'Sister': { class: 'daughter', icon: 'fa-female', color: '#fed7aa' },
            'Grandfather': { class: 'father', icon: 'fa-male', color: '#dbeafe' },
            'Grandmother': { class: 'mother', icon: 'fa-female', color: '#fce7f3' }
        };

        if (select.value === 'Other') {
            input.value = '';
            input.readOnly = false;
            input.focus();
            if (previewRelation) previewRelation.textContent = 'Other (specify)';
            if (previewIcon) {
                previewIcon.style.background = '#e2e8f0';
                previewIcon.innerHTML = '<i class="fas fa-user"></i>';
            }
        } else if (select.value) {
            input.value = select.value;
            input.readOnly = true;
            if (previewRelation) previewRelation.textContent = select.value;

            // Update preview icon based on relation
            if (previewIcon && relationClasses[select.value]) {
                previewIcon.style.background = relationClasses[select.value].color;
                previewIcon.innerHTML = `<i class="fas ${relationClasses[select.value].icon}"></i>`;
            }

            // Update main icon
            if (previewIconMain && relationClasses[select.value]) {
                previewIconMain.innerHTML = `<i class="fas ${relationClasses[select.value].icon}"></i>`;
            }
        }
    }

    // Preview name as user types
    document.querySelector('[name="name"]').addEventListener('input', function(e) {
        const preview = document.getElementById('preview_name');
        if (preview) {
            preview.textContent = this.value || '{{ $familyMember->name }}';
        }
    });

    // Mobile number validation
    document.querySelector('[name="mobile"]').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial preview
        const nameInput = document.querySelector('[name="name"]');
        if (nameInput) {
            document.getElementById('preview_name').textContent = nameInput.value;
        }
    });

    // Form submission loading state
    document.getElementById('editForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
        submitBtn.classList.add('loading');
    });

    // Validate form before submit
    document.getElementById('editForm').addEventListener('submit', function(e) {
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
