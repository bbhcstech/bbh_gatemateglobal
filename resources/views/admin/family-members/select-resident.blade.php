@extends('admin.layout.app')

@section('title', 'Select Resident')

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
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
    }

    .header-icon span {
        font-size: 2rem;
        color: white;
    }

    .header-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .header-subtitle {
        color: var(--secondary);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Main Card */
    .main-card {
        background: white;
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-header {
        background: #f9fafc;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h5 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
    }

    .card-header h5 i {
        color: var(--primary);
    }

    .total-badge {
        background: var(--primary);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 30px;
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Search Section */
    .search-section {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border);
        background: white;
    }

    .search-box {
        position: relative;
        max-width: 400px;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--secondary);
    }

    .search-box input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 2.75rem;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .search-box input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    /* Residents Grid */
    .residents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        padding: 2rem;
    }

    .resident-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: block;
        position: relative;
        overflow: hidden;
    }

    .resident-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        border-color: var(--primary);
    }

    .resident-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
        opacity: 0;
        transition: opacity 0.3s;
    }

    .resident-card:hover::before {
        opacity: 1;
    }

    .resident-avatar {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
    }

    .resident-type {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        padding: 0.35rem 1rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .type-owner {
        background: #d1fae5;
        color: #065f46;
    }

    .type-tenant {
        background: #fef3c7;
        color: #92400e;
    }

    .resident-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.75rem;
    }

    .resident-details {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        margin-bottom: 1.25rem;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--secondary);
        font-size: 0.9rem;
    }

    .detail-item i {
        width: 18px;
        color: var(--primary);
    }

    .family-count {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #f1f5f9;
        color: var(--dark);
        padding: 0.5rem 1rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    .family-count i {
        color: var(--primary);
    }

    /* Empty State */
    .empty-state {
        grid-column: 1/-1;
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--border);
        margin-bottom: 1.5rem;
    }

    .empty-state h6 {
        color: var(--dark);
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: var(--secondary);
        font-size: 0.95rem;
        max-width: 400px;
        margin: 0 auto;
    }

    /* Back Button */
    .back-button {
        background: white;
        color: var(--secondary);
        border: 1.5px solid var(--border);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.2s;
        font-weight: 500;
    }

    .back-button:hover {
        background: #f8fafc;
        border-color: var(--secondary);
        color: var(--dark);
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <div class="header-icon">
                <span>🏘️</span>
            </div>
            <div>
                <h1 class="header-title">Select Resident</h1>
                <div class="header-subtitle">
                    <i class="fas fa-circle"></i>
                    <span>Choose a resident to add family members</span>
                </div>
            </div>
        </div>
        <div>
            <a href="{{ route('family-members.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Family Members
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-building"></i>
                Residents Directory
            </h5>
            <span class="total-badge">
                <i class="fas fa-users me-2"></i>
                {{ $residents->count() }} Residents
            </span>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search by name, flat number, or phone..." autocomplete="off">
            </div>
        </div>

        <!-- Residents Grid -->
        <div class="residents-grid" id="residentsGrid">
            @forelse($residents as $resident)
                <a href="{{ route('family-members.create', ['resident_id' => $resident->id]) }}" class="resident-card"
                   data-name="{{ strtolower($resident->name) }}"
                   data-flat="{{ strtolower($resident->flat_no ?? '') }}"
                   data-phone="{{ $resident->phone ?? '' }}">
                    <div class="resident-type type-{{ $resident->type ?? 'owner' }}">
                        {{ ucfirst($resident->type ?? 'Owner') }}
                    </div>

                    <div class="resident-avatar">
                        {{ strtoupper(substr($resident->name, 0, 1)) }}
                    </div>

                    <div class="resident-name">
                        {{ $resident->name }}
                    </div>

                    <div class="resident-details">
                        <div class="detail-item">
                            <i class="fas fa-hashtag"></i>
                            <span>Flat No: <strong>{{ $resident->flat_no ?? 'Not Assigned' }}</strong></span>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-phone"></i>
                            <span>{{ $resident->phone ?? 'No phone number' }}</span>
                        </div>

                        @if($resident->email)
                        <div class="detail-item">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $resident->email }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="family-count">
                        <i class="fas fa-users"></i>
                        {{ $resident->family_members_count ?? 0 }} Family Member(s)
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h6>No Residents Found</h6>
                    <p>There are no residents registered in the system yet. Please add residents first.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Live search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let searchText = this.value.toLowerCase();
        let cards = document.querySelectorAll('.resident-card');
        let visibleCount = 0;

        cards.forEach(card => {
            let name = card.dataset.name || '';
            let flat = card.dataset.flat || '';
            let phone = card.dataset.phone || '';

            if (name.includes(searchText) || flat.includes(searchText) || phone.includes(searchText)) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide empty state message
        let emptyState = document.querySelector('.empty-state');
        if (emptyState) {
            if (visibleCount === 0) {
                if (!document.querySelector('.no-results-message')) {
                    let noResults = document.createElement('div');
                    noResults.className = 'empty-state no-results-message';
                    noResults.innerHTML = `
                        <div class="empty-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h6>No Matching Residents</h6>
                        <p>No residents found matching "${this.value}"</p>
                    `;
                    document.getElementById('residentsGrid').appendChild(noResults);
                }
            } else {
                let noResultsMsg = document.querySelector('.no-results-message');
                if (noResultsMsg) {
                    noResultsMsg.remove();
                }
            }
        }
    });

    // Clear search on page load if needed
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const searchParam = urlParams.get('search');
        if (searchParam) {
            document.getElementById('searchInput').value = searchParam;
            document.getElementById('searchInput').dispatchEvent(new Event('keyup'));
        }
    });
</script>
@endpush
