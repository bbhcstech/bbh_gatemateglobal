@extends('admin.layout.app')

@section('title', 'Add Family Member')

@section('content')
<style>
    .required:after {
        content: " *";
        color: #ef4444;
    }

    .form-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .form-header {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 1.5rem;
    }

    .resident-badge {
        background: rgba(255,255,255,0.2);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        backdrop-filter: blur(5px);
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-plus fa-3x me-3"></i>
                        <div>
                            <h4 class="mb-1">Add New Family Member</h4>
                            <p class="mb-0 opacity-75">Add a family member to the resident's profile</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- Resident Information Summary --}}
                    @if(isset($selectedResident))
                        <div class="alert alert-info d-flex align-items-center mb-4">
                            <i class="fas fa-info-circle fa-2x me-3"></i>
                            <div>
                                <strong>Adding member for:</strong><br>
                                {{ $selectedResident->name }}
                                <span class="mx-2">|</span>
                                Flat: {{ $selectedResident->flat_no }}
                                <span class="mx-2">|</span>
                                ID: #{{ $selectedResident->id }}
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('family-members.store') }}" id="familyForm">
                        @csrf

                        {{-- Resident Selection for Admin --}}
                        @if(auth()->user()->role == 'admin' && !isset($selectedResident))
                        <div class="mb-4">
                            <label class="form-label required fw-bold">Select Resident</label>
                            <select name="resident_id" class="form-select @error('resident_id') is-invalid @enderror" required>
                                <option value="">-- Choose Resident --</option>
                                @foreach($residents as $resident)
                                    <option value="{{ $resident->id }}" {{ old('resident_id') == $resident->id ? 'selected' : '' }}>
                                        {{ $resident->name }} - Flat {{ $resident->flat_no }} (ID: {{ $resident->id }}) - {{ ucfirst($resident->type) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('resident_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Select the resident who this family member belongs to
                            </small>
                        </div>
                        @elseif(isset($selectedResident))
                            <input type="hidden" name="resident_id" value="{{ $selectedResident->id }}">
                        @endif

                        {{-- Member Name --}}
                        <div class="mb-4">
                            <label class="form-label required fw-bold">Member Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <input type="text"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}"
                                       placeholder="Enter full name"
                                       required>
                            </div>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Relation --}}
                        <div class="mb-4">
                            <label class="form-label required fw-bold">Relationship</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-heart text-danger"></i>
                                </span>
                                <select name="relation_id" class="form-select @error('relation_id') is-invalid @enderror" required>
                                    <option value="">-- Select Relation --</option>
                                    @foreach($relations as $relation)
                                        <option value="{{ $relation->id }}" {{ old('relation_id') == $relation->id ? 'selected' : '' }}>
                                            {{ $relation->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('relation_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mobile Number --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Mobile Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-phone-alt text-success"></i>
                                </span>
                                <input type="text"
                                       name="mobile"
                                       class="form-control @error('mobile') is-invalid @enderror"
                                       value="{{ old('mobile') }}"
                                       placeholder="Enter mobile number (optional)">
                            </div>
                            @error('mobile')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Recommended for gate access and emergency contacts
                            </small>
                        </div>

                        {{-- Additional Options --}}
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="sendNotification" name="send_notification" value="1">
                                <label class="form-check-label" for="sendNotification">
                                    <i class="fas fa-bell me-1 text-warning"></i>
                                    Send notification to resident
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="generateQR" name="generate_qr" value="1">
                                <label class="form-check-label" for="generateQR">
                                    <i class="fas fa-qrcode me-1 text-info"></i>
                                    Generate QR code for gate pass
                                </label>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('family-members.index', ['resident_id' => $selectedResident->id ?? '']) }}"
                               class="btn btn-secondary btn-lg px-4">
                                <i class="fas fa-times me-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-save me-2"></i>
                                Save Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Form validation
document.getElementById('familyForm')?.addEventListener('submit', function(e) {
    const name = this.querySelector('[name="name"]').value;
    if(name.length < 2) {
        e.preventDefault();
        alert('Name must be at least 2 characters long');
    }
});

// Mobile number formatting (optional)
document.querySelector('[name="mobile"]')?.addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
@endpush

@endsection
