@extends('admin.layout.app')

@section('title', 'Select Resident')

@section('content')
<style>
    .resident-select-card {
        transition: all 0.2s;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .resident-select-card:hover {
        transform: translateY(-2px);
        border-color: #2563eb;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.1);
    }

    .search-box {
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .search-box:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px #dbeafe;
        outline: none;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-plus fa-2x me-3"></i>
                        <div>
                            <h4 class="mb-1">Add Family Member</h4>
                            <p class="mb-0 opacity-75">First, select which resident's family you want to add to</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- Search Box --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-search text-primary me-2"></i>
                            Search Resident
                        </label>
                        <input type="text"
                               id="searchInput"
                               class="form-control search-box"
                               placeholder="Type name, flat number, or phone number...">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Type at least 2 characters to search
                        </small>
                    </div>

                    {{-- Quick Filters --}}
                    <div class="mb-4">
                        <span class="fw-bold me-2">Quick Filters:</span>
                        <button type="button" class="btn btn-sm btn-outline-primary me-1" onclick="filterType('all')">All</button>
                        <button type="button" class="btn btn-sm btn-outline-primary me-1" onclick="filterType('owner')">Owners</button>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="filterType('tenant')">Tenants</button>
                    </div>

                    {{-- Residents List --}}
                    <div class="row" id="residentList">
                        @forelse($residents as $resident)
                            <div class="col-md-6 col-lg-4 mb-3 resident-item"
                                 data-name="{{ strtolower($resident->name) }}"
                                 data-flat="{{ strtolower($resident->flat_no ?? '') }}"
                                 data-phone="{{ $resident->phone }}"
                                 data-type="{{ $resident->type }}">
                                <div class="card resident-select-card h-100"
                                     onclick="selectResident({{ $resident->id }})">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title mb-0">{{ $resident->name }}</h6>
                                            @if($resident->type == 'owner')
                                                <span class="badge bg-primary">Owner</span>
                                            @else
                                                <span class="badge bg-info">Tenant</span>
                                            @endif
                                        </div>
                                        <p class="card-text small">
                                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                            Flat: {{ $resident->flat_no }}<br>
                                            <i class="fas fa-phone-alt text-success me-1"></i>
                                            {{ $resident->phone }}<br>
                                            <i class="fas fa-users text-info me-1"></i>
                                            Family: {{ $resident->familyMembers->count() }} members
                                        </p>
                                        <div class="mt-2">
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-id-card me-1"></i>
                                                ID: #{{ $resident->id }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center py-5">
                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                    <h5>No Residents Found</h5>
                                    <p>Please add residents first before adding family members.</p>
                                    <a href="{{ route('residents.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add Resident
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Empty State --}}
                    <div id="noResults" class="text-center py-5" style="display: none;">
                        <i class="fas fa-search fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No matching residents found</h5>
                        <p class="text-muted">Try different search keywords or filters</p>
                    </div>
                </div>

                <div class="card-footer bg-light">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Total Residents: {{ $residents->count() }} |
                        Owners: {{ $residents->where('type', 'owner')->count() }} |
                        Tenants: {{ $residents->where('type', 'tenant')->count() }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentFilter = 'all';
let searchTimeout;

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        filterResidents();
    }, 300);
});

// Filter by type
function filterType(type) {
    currentFilter = type;

    // Update active button styles
    document.querySelectorAll('.btn-outline-primary').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');

    filterResidents();
}

// Filter residents
function filterResidents() {
    const search = document.getElementById('searchInput').value.toLowerCase().trim();
    const items = document.querySelectorAll('.resident-item');
    let visibleCount = 0;

    items.forEach(item => {
        const name = item.dataset.name;
        const flat = item.dataset.flat;
        const phone = item.dataset.phone;
        const type = item.dataset.type;

        let matchesSearch = true;
        if(search.length > 1) {
            matchesSearch = name.includes(search) ||
                           flat.includes(search) ||
                           phone.includes(search);
        }

        let matchesType = true;
        if(currentFilter !== 'all') {
            matchesType = type === currentFilter;
        }

        if(matchesSearch && matchesType) {
            item.style.display = '';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    // Show/hide no results message
    document.getElementById('noResults').style.display = visibleCount === 0 ? 'block' : 'none';
}

// Select resident
function selectResident(id) {
    window.location.href = "{{ route('family-members.create') }}?resident_id=" + id;
}

// Reset search
document.addEventListener('keydown', function(e) {
    if(e.key === 'Escape') {
        document.getElementById('searchInput').value = '';
        filterResidents();
    }
});
</script>
@endpush

@endsection
