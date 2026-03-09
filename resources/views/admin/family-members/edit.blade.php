@extends('admin.layout.app')

@section('title', 'Edit Family Member')

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
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 1.5rem;
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-edit fa-3x me-3"></i>
                        <div>
                            <h4 class="mb-1">Edit Family Member</h4>
                            <p class="mb-0 opacity-75">Update family member information</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- Resident Information --}}
                    <div class="alert alert-info d-flex align-items-center mb-4">
                        <i class="fas fa-info-circle fa-2x me-3"></i>
                        <div>
                            <strong>Resident:</strong> {{ $familyMember->resident->name }}
                            <span class="mx-2">|</span>
                            Flat: {{ $familyMember->resident->flat_no }}
                            <span class="mx-2">|</span>
                            ID: #{{ $familyMember->resident->id }}
                        </div>
                    </div>

                    <form method="POST" action="{{ route('family-members.update', $familyMember) }}" id="editForm">
                        @csrf
                        @method('PUT')

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
                                       value="{{ old('name', $familyMember->name) }}"
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
                                        <option value="{{ $relation->id }}"
                                            {{ (old('relation_id', $familyMember->relation_id) == $relation->id) ? 'selected' : '' }}>
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
                                       value="{{ old('mobile', $familyMember->mobile) }}"
                                       placeholder="Enter mobile number">
                            </div>
                            @error('mobile')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Audit Trail (View Only) --}}
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="mb-3">
                                    <i class="fas fa-history text-primary me-2"></i>
                                    Audit Information
                                </h6>
                                <div class="row small">
                                    <div class="col-md-6">
                                        <span class="text-muted">Created:</span><br>
                                        <strong>{{ $familyMember->created_at->format('d M Y, h:i A') }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Last Updated:</span><br>
                                        <strong>{{ $familyMember->updated_at->format('d M Y, h:i A') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('family-members.index', ['resident_id' => $familyMember->resident_id]) }}"
                               class="btn btn-secondary btn-lg px-4">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg px-5">
                                <i class="fas fa-save me-2"></i>
                                Update Member
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
// Mobile number formatting
document.querySelector('[name="mobile"]')?.addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
@endpush

@endsection
