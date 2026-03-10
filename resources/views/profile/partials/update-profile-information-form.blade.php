@extends('admin.layout.app')

@section('title', 'Resident Profile')

@section('content')
<main id="main" class="main">
    <div class="container-fluid px-4 mt-4">

        <!-- Page Title & Breadcrumb -->
        <div class="pagetitle mb-4">
            <h1>Resident Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        @if(Auth::check())
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
                                    <img src="{{ asset('admin/assets/img/logo.png') }}" alt="" class="me-2" style="height:24px;">
                                    Micro Poem Admin
                                </a>
                            @elseif(Auth::user()->role === 'manager')
                                <a href="{{ route('manager.dashboard') }}" class="d-flex align-items-center">
                                    <img src="{{ asset('admin/assets/img/logo.png') }}" alt="" class="me-2" style="height:24px;">
                                    Micro Poem Manager
                                </a>
                            @elseif(Auth::user()->role === 'resident')
                                <a href="{{ route('resident.dashboard') }}" class="d-flex align-items-center">
                                    <img src="{{ asset('admin/assets/img/logo.png') }}" alt="" class="me-2" style="height:24px;">
                                    Micro Poem Resident
                                </a>
                            @endif
                        @endif
                    </li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div>

            <!-- Profile Header with Cover Photo -->
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
            <!-- Cover Photo - Light Purple Gradient -->
            <div class="cover-photo position-relative" style="height: 200px; background: linear-gradient(135deg, #f3e5ff 0%, #e8d5ff 100%);">
                <!-- Flat Badge - Positioned at Bottom Right -->
                <div class="position-absolute bottom-0 end-0 p-4">
                    <span class="badge bg-white px-4 py-3 rounded-pill shadow-sm"
                        style="color: #553c9a; border: 1px solid #e9d5ff; font-size: 0.95rem; font-weight: 500;">
                        <i class="bi bi-house-door-fill me-2" style="color: #9f7aea;"></i>
                        {{ $user->flat_number ?? 'Flat Not Assigned' }}
                    </span>
                </div>

                <!-- Optional: Add a subtle pattern overlay -->
                <div class="position-absolute top-0 start-0 w-100 h-100"
                    style="background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.2) 0%, transparent 50%);">
                </div>
            </div>

            <!-- Profile Info -->
            <div class="px-4 pb-4 position-relative">
                <div class="row">
                    <div class="col-auto">
                        <div class="profile-avatar-wrapper mt-n5">
                            @php
                                $profilePicUrl = null;
                                if ($user->profilePicture && $user->profilePicture->file_path) {
                                    $profilePicUrl = asset($user->profilePicture->file_path);
                                }
                            @endphp

                            @if($profilePicUrl)
                                <img src="{{ $profilePicUrl }}"
                                     class="rounded-circle border-4 border-white shadow"
                                     style="width: 140px; height: 140px; object-fit: cover;"
                                     alt="{{ $user->name }}">
                            @else
                                <div class="rounded-circle border-4 border-white shadow d-flex align-items-center justify-content-center"
                                     style="width: 140px; height: 140px; background: linear-gradient(135deg, #b794f4 0%, #9f7aea 100%);">
                                    <span class="text-white" style="font-size: 3.5rem; font-weight: 500;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif

                        <button class="btn position-absolute bottom-0 end-0 d-flex align-items-center gap-2 shadow-sm rounded-pill"
                                data-bs-toggle="modal"
                                data-bs-target="#updateProfilePicModal"
                                style="background: white;
                                    border: 2px solid #9f7aea;
                                    color: #9f7aea;
                                    padding: 8px 16px;
                                    font-size: 0.9rem;
                                    font-weight: 500;
                                    transition: all 0.3s ease;
                                    z-index: 10;
                                    transform: translateY(-50%);"
                                onmouseover="this.style.background='#9f7aea'; this.style.color='white'"
                                onmouseout="this.style.background='white'; this.style.color='#9f7aea'">
                            <i class="bi bi-camera-fill"></i>
                            <span>Upload Image</span>
                        </button>
                    </div>
                </div>
                    <div class="col">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mt-3">
                            <div>
                                <h2 class="fw-bold mb-1" style="color: #2d3748;">{{ $user->name }}</h2>
                                <div class="d-flex flex-wrap gap-3">
                                    <span class="text-muted"><i class="bi bi-envelope-fill me-1" style="color: #9f7aea;"></i>{{ $user->email }}</span>
                                    <span class="text-muted"><i class="bi bi-telephone-fill me-1" style="color: #9f7aea;"></i>{{ $user->mobile }}</span>
                                    @if($user->whatsapp_no)
                                    <span class="text-muted"><i class="bi bi-whatsapp me-1" style="color: #9f7aea;"></i>{{ $user->whatsapp_no }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2 mt-md-0">
                                <span class="badge p-3 rounded-pill" style="background: #f3e5ff; color: #9f7aea; border: 1px solid #d6b5ff;">
                                    <i class="bi bi-person-badge me-2"></i>ID: {{ $user->resident_id ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Tabs Navigation -->
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-transparent border-0 pt-4">
                <ul class="nav nav-tabs card-header-tabs nav-fill" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">
                            <i class="bi bi-person-circle me-2" style="color: #9f7aea;"></i>Personal Info
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="family-tab" data-bs-toggle="tab" data-bs-target="#family" type="button" role="tab">
                            <i class="bi bi-people-fill me-2" style="color: #9f7aea;"></i>Family
                            @php $familyCount = optional($user->familyMembers)->count() ?? 0; @endphp
                            @if($familyCount > 0)
                                <span class="badge ms-2" style="background: #9f7aea; color: white;">{{ $familyCount }}</span>
                            @endif
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pets-tab" data-bs-toggle="tab" data-bs-target="#pets" type="button" role="tab">
                            <i class="bi bi-heart-fill me-2" style="color: #9f7aea;"></i>Pets
                            @php $petsCount = optional($user->pets)->count() ?? 0; @endphp
                            @if($petsCount > 0)
                                <span class="badge ms-2" style="background: #9f7aea; color: white;">{{ $petsCount }}</span>
                            @endif
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="vehicles-tab" data-bs-toggle="tab" data-bs-target="#vehicles" type="button" role="tab">
                            <i class="bi bi-car-front-fill me-2" style="color: #9f7aea;"></i>Vehicles
                            @php $vehiclesCount = optional($user->vehicles)->count() ?? 0; @endphp
                            @if($vehiclesCount > 0)
                                <span class="badge ms-2" style="background: #9f7aea; color: white;">{{ $vehiclesCount }}</span>
                            @endif
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">
                            <i class="bi bi-file-earmark-text-fill me-2" style="color: #9f7aea;"></i>Documents
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab">
                            <i class="bi bi-gear-fill me-2" style="color: #9f7aea;"></i>Settings
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="profileTabsContent">

                    <!-- ==================== PERSONAL INFO TAB ==================== -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card border-0" style="background: #faf5ff;">
                                    <div class="card-body p-4">
                                        <h5 class="mb-4" style="color: #553c9a;"><i class="bi bi-pencil-square me-2" style="color: #9f7aea;"></i>Edit Personal Information</h5>

                                        <form method="post" action="{{ route('profile.update') }}" class="row g-4">
                                            @csrf
                                            @method('patch')

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-muted">Full Name</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-0" style="color: #9f7aea;"><i class="bi bi-person"></i></span>
                                                    <input type="text" class="form-control border-0 bg-white" value="{{ $user->name }}" readonly disabled style="background: #f5f0ff;">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-muted">Email Address</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-0" style="color: #9f7aea;"><i class="bi bi-envelope"></i></span>
                                                    <input type="email" class="form-control border-0 @error('email') is-invalid @enderror"
                                                           name="email" value="{{ old('email', $user->email) }}" required style="background: #f5f0ff;">
                                                </div>
                                                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-muted">Mobile Number</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-0" style="color: #9f7aea;"><i class="bi bi-phone"></i></span>
                                                    <input type="text" class="form-control border-0" value="{{ $user->mobile }}" readonly disabled style="background: #f5f0ff;">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-muted">WhatsApp Number</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-0" style="color: #9f7aea;"><i class="bi bi-whatsapp"></i></span>
                                                    <input type="text" class="form-control border-0 @error('whatsapp_no') is-invalid @enderror"
                                                           name="whatsapp_no" value="{{ old('whatsapp_no', $user->whatsapp_no) }}" style="background: #f5f0ff;">
                                                </div>
                                                @error('whatsapp_no')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-muted">Flat Number</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-0" style="color: #9f7aea;"><i class="bi bi-house"></i></span>
                                                    <input type="text" class="form-control border-0" value="{{ $user->flat_number ?? 'Not Assigned' }}" readonly disabled style="background: #f5f0ff;">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-muted">Occupation</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-0" style="color: #9f7aea;"><i class="bi bi-briefcase"></i></span>
                                                    <input type="text" class="form-control border-0 @error('occupation') is-invalid @enderror"
                                                           name="occupation" value="{{ old('occupation', $user->occupation ?? '') }}" style="background: #f5f0ff;">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-semibold text-muted">About / Bio</label>
                                                <textarea class="form-control border-0 @error('bio') is-invalid @enderror"
                                                          name="bio" rows="3" style="background: #f5f0ff;">{{ old('bio', $user->bio ?? '') }}</textarea>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" class="btn px-5 py-2 rounded-pill" style="background: #9f7aea; color: white; border: none;">
                                                    <i class="bi bi-check-circle me-2"></i>Save Changes
                                                </button>
                                                @if(session('status') === 'profile-updated')
                                                    <span class="ms-3" style="color: #9f7aea;"><i class="bi bi-check-circle-fill me-1"></i>Saved!</span>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card border-0" style="background: linear-gradient(135deg, #f3e5ff 0%, #e8d5ff 100%);">
                                    <div class="card-body p-4">
                                        <h5 class="mb-3" style="color: #553c9a;"><i class="bi bi-info-circle-fill me-2"></i>Quick Stats</h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-2" style="color: #4a5568;"><i class="bi bi-people-fill me-2" style="color: #9f7aea;"></i>Family: {{ optional($user->familyMembers)->count() ?? 0 }}</li>
                                            <li class="mb-2" style="color: #4a5568;"><i class="bi bi-heart-fill me-2" style="color: #9f7aea;"></i>Pets: {{ optional($user->pets)->count() ?? 0 }}</li>
                                            <li class="mb-2" style="color: #4a5568;"><i class="bi bi-car-front-fill me-2" style="color: #9f7aea;"></i>Vehicles: {{ optional($user->vehicles)->count() ?? 0 }}</li>
                                            <li class="mb-2" style="color: #4a5568;"><i class="bi bi-calendar-check me-2" style="color: #9f7aea;"></i>Since: {{ optional($user->created_at)->format('M Y') ?? 'N/A' }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== FAMILY MEMBERS TAB ==================== -->
                    <div class="tab-pane fade" id="family" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 style="color: #553c9a;"><i class="bi bi-people-fill me-2" style="color: #9f7aea;"></i>Family Members</h4>
                            <button class="btn rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addFamilyMemberModal" style="background: #9f7aea; color: white; border: none;">
                                <i class="bi bi-plus-circle me-2"></i>Add Member
                            </button>
                        </div>

                        @php $familyMembers = optional($user->familyMembers) ?? collect(); @endphp
                        @if($familyMembers->count() > 0)
                            <div class="row g-4">
                                @foreach($familyMembers as $member)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border-0 shadow-sm hover-card" style="border-radius: 15px; background: white;">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center mb-3">
                                                @php
                                                    $memberPic = null;
                                                    if($member->profile_pic) {
                                                        $memberPic = asset($member->profile_pic);
                                                    }
                                                @endphp

                                                @if($memberPic)
                                                    <img src="{{ $memberPic }}" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #e9d5ff;">
                                                @else
                                                    <div class="rounded-circle me-3 d-flex align-items-center justify-content-center"
                                                         style="width: 60px; height: 60px; background: #f3e5ff; border: 2px solid #e9d5ff;">
                                                        <span style="color: #9f7aea; font-size: 1.5rem; font-weight: 500;">{{ substr($member->name, 0, 1) }}</span>
                                                    </div>
                                                @endif

                                                <div>
                                                    <h6 class="mb-1 fw-bold" style="color: #2d3748;">{{ $member->name }}</h6>
                                                    <span class="badge" style="background: #f3e5ff; color: #9f7aea;">{{ $member->relationship ?? 'Family' }}</span>
                                                    @if($member->is_emergency_contact)
                                                        <span class="badge ms-1" style="background: #fc8181; color: white;">Emergency</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="small">
                                                <div class="mb-1"><i class="bi bi-phone me-2" style="color: #9f7aea;"></i>{{ $member->mobile ?? 'No phone' }}</div>
                                                <div class="mb-1"><i class="bi bi-envelope me-2" style="color: #9f7aea;"></i>{{ $member->email ?? 'No email' }}</div>
                                                <div><i class="bi bi-gender-{{ $member->gender ?? 'male' }} me-2" style="color: #9f7aea;"></i>{{ ucfirst($member->gender ?? 'N/A') }}, {{ $member->age ?? 'N/A' }} years</div>
                                            </div>

                                            <div class="d-flex justify-content-end gap-2 mt-3">
                                                <button class="btn btn-sm" onclick="editFamilyMember({{ $member->id }})" style="background: #f3e5ff; color: #9f7aea;">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm" onclick="deleteFamilyMember({{ $member->id }})" style="background: #fee2e2; color: #ef4444;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-people" style="font-size: 4rem; color: #e9d5ff;"></i>
                                </div>
                                <h5 class="text-muted">No Family Members Added</h5>
                                <p class="text-muted small">Add your family members to manage them here.</p>
                                <button class="btn rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addFamilyMemberModal" style="background: #9f7aea; color: white; border: none;">
                                    <i class="bi bi-plus-circle me-2"></i>Add First Member
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- ==================== PETS TAB ==================== -->
                    <div class="tab-pane fade" id="pets" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 style="color: #553c9a;"><i class="bi bi-heart-fill me-2" style="color: #9f7aea;"></i>My Pets</h4>
                            <button class="btn rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addPetModal" style="background: #9f7aea; color: white; border: none;">
                                <i class="bi bi-plus-circle me-2"></i>Add Pet
                            </button>
                        </div>

                        @php $pets = optional($user->pets) ?? collect(); @endphp
                        @if($pets->count() > 0)
                            <div class="row g-4">
                                @foreach($pets as $pet)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border-0 shadow-sm hover-card" style="border-radius: 15px; background: white;">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center mb-3">
                                                @php
                                                    $petPic = null;
                                                    if($pet->profile_pic) {
                                                        $petPic = asset($pet->profile_pic);
                                                    }
                                                @endphp

                                                @if($petPic)
                                                    <img src="{{ $petPic }}" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #e9d5ff;">
                                                @else
                                                    <div class="rounded-circle me-3 d-flex align-items-center justify-content-center"
                                                         style="width: 60px; height: 60px; background: #f3e5ff; border: 2px solid #e9d5ff;">
                                                        <i class="bi bi-heart-fill" style="color: #9f7aea; font-size: 1.5rem;"></i>
                                                    </div>
                                                @endif

                                                <div>
                                                    <h6 class="mb-1 fw-bold" style="color: #2d3748;">{{ $pet->name }}</h6>
                                                    <span class="badge" style="background: #f3e5ff; color: #9f7aea;">{{ ucfirst($pet->type) }}</span>
                                                </div>
                                            </div>

                                            <div class="small">
                                                <div class="mb-1"><i class="bi bi-tag me-2" style="color: #9f7aea;"></i>{{ $pet->breed ?? 'Mixed Breed' }}</div>
                                                <div class="mb-1"><i class="bi bi-calendar me-2" style="color: #9f7aea;"></i>{{ $pet->age ?? 'N/A' }} years old</div>
                                                @if($pet->registration_number)
                                                <div class="mb-1"><i class="bi bi-qr-code me-2" style="color: #9f7aea;"></i>{{ $pet->registration_number }}</div>
                                                @endif
                                            </div>

                                            @if($pet->vaccination_details)
                                                <div class="mt-2 p-2 small rounded" style="background: #f0fff4; color: #38a169;">
                                                    <i class="bi bi-shield-check me-1"></i>Vaccinated
                                                </div>
                                            @endif

                                            <div class="d-flex justify-content-end gap-2 mt-3">
                                                <button class="btn btn-sm" onclick="editPet({{ $pet->id }})" style="background: #f3e5ff; color: #9f7aea;">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm" onclick="deletePet({{ $pet->id }})" style="background: #fee2e2; color: #ef4444;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-heart" style="font-size: 4rem; color: #e9d5ff;"></i>
                                </div>
                                <h5 class="text-muted">No Pets Added</h5>
                                <p class="text-muted small">Add your furry friends to manage them here.</p>
                                <button class="btn rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addPetModal" style="background: #9f7aea; color: white; border: none;">
                                    <i class="bi bi-plus-circle me-2"></i>Add First Pet
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- ==================== VEHICLES TAB ==================== -->
                    <div class="tab-pane fade" id="vehicles" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 style="color: #553c9a;"><i class="bi bi-car-front-fill me-2" style="color: #9f7aea;"></i>My Vehicles</h4>
                            <button class="btn rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addVehicleModal" style="background: #9f7aea; color: white; border: none;">
                                <i class="bi bi-plus-circle me-2"></i>Add Vehicle
                            </button>
                        </div>

                        @php $vehicles = optional($user->vehicles) ?? collect(); @endphp
                        @if($vehicles->count() > 0)
                            <div class="row g-4">
                                @foreach($vehicles as $vehicle)
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm hover-card" style="border-radius: 15px; background: white;">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="me-3 d-flex align-items-center justify-content-center"
                                                     style="width: 60px; height: 60px; background: #f3e5ff; border-radius: 12px;">
                                                    @if($vehicle->type === 'car')
                                                        <i class="bi bi-car-front-fill" style="color: #9f7aea; font-size: 2rem;"></i>
                                                    @elseif($vehicle->type === 'bike')
                                                        <i class="bi bi-bicycle" style="color: #9f7aea; font-size: 2rem;"></i>
                                                    @else
                                                        <i class="bi bi-truck" style="color: #9f7aea; font-size: 2rem;"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold" style="color: #2d3748;">{{ $vehicle->model ?? 'Vehicle' }}</h6>
                                                    <span class="badge" style="background: #f3e5ff; color: #9f7aea;">{{ strtoupper($vehicle->registration_number ?? 'N/A') }}</span>
                                                </div>
                                            </div>

                                            <div class="row g-2 small">
                                                <div class="col-6">
                                                    <span class="text-muted d-block">Type</span>
                                                    <span style="color: #2d3748;">{{ ucfirst($vehicle->type ?? 'N/A') }}</span>
                                                </div>
                                                <div class="col-6">
                                                    <span class="text-muted d-block">Color</span>
                                                    <span style="color: #2d3748;">{{ $vehicle->color ?? 'N/A' }}</span>
                                                </div>
                                                <div class="col-6">
                                                    <span class="text-muted d-block">Parking</span>
                                                    <span style="color: #2d3748;">{{ $vehicle->parking_slot_number ?? 'Not assigned' }}</span>
                                                </div>
                                                <div class="col-6">
                                                    <span class="text-muted d-block">Fuel</span>
                                                    <span style="color: #2d3748;">{{ ucfirst($vehicle->fuel_type ?? 'N/A') }}</span>
                                                </div>
                                            </div>

                                            @if($vehicle->insurance_expiry || $vehicle->pollution_expiry)
                                            <hr class="my-2">
                                            <div class="row g-2 small">
                                                @if($vehicle->insurance_expiry)
                                                <div class="col-6">
                                                    <span class="text-muted d-block">Insurance</span>
                                                    @php
                                                        $insuranceDate = \Carbon\Carbon::parse($vehicle->insurance_expiry);
                                                        $isExpired = now() > $insuranceDate;
                                                    @endphp
                                                    <span style="color: {{ $isExpired ? '#ef4444' : '#38a169' }};">
                                                        {{ $insuranceDate->format('d M Y') }}
                                                    </span>
                                                </div>
                                                @endif
                                                @if($vehicle->pollution_expiry)
                                                <div class="col-6">
                                                    <span class="text-muted d-block">Pollution</span>
                                                    @php
                                                        $pollutionDate = \Carbon\Carbon::parse($vehicle->pollution_expiry);
                                                        $isExpired = now() > $pollutionDate;
                                                    @endphp
                                                    <span style="color: {{ $isExpired ? '#ef4444' : '#38a169' }};">
                                                        {{ $pollutionDate->format('d M Y') }}
                                                    </span>
                                                </div>
                                                @endif
                                            </div>
                                            @endif

                                            <div class="d-flex justify-content-end gap-2 mt-3">
                                                @if($vehicle->rc_document)
                                                <a href="{{ asset($vehicle->rc_document) }}" target="_blank" class="btn btn-sm" style="background: #f3e5ff; color: #9f7aea;">
                                                    <i class="bi bi-file-pdf"></i>
                                                </a>
                                                @endif
                                                <button class="btn btn-sm" onclick="editVehicle({{ $vehicle->id }})" style="background: #f3e5ff; color: #9f7aea;">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm" onclick="deleteVehicle({{ $vehicle->id }})" style="background: #fee2e2; color: #ef4444;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-car-front" style="font-size: 4rem; color: #e9d5ff;"></i>
                                </div>
                                <h5 class="text-muted">No Vehicles Added</h5>
                                <p class="text-muted small">Add your vehicles for easy management.</p>
                                <button class="btn rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addVehicleModal" style="background: #9f7aea; color: white; border: none;">
                                    <i class="bi bi-plus-circle me-2"></i>Add First Vehicle
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- ==================== DOCUMENTS TAB ==================== -->
                    <div class="tab-pane fade" id="documents" role="tabpanel">
                        <h4 class="mb-4" style="color: #553c9a;"><i class="bi bi-file-earmark-text-fill me-2" style="color: #9f7aea;"></i>My Documents</h4>

                        @if($user->document)
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                                        <div class="card-body p-4">
                                            @php
                                                $document = $user->document;
                                                $filePath = $document->file_path ?? '';
                                                $extension = $filePath ? pathinfo($filePath, PATHINFO_EXTENSION) : '';
                                                $createdAt = $document->created_at ?? null;
                                            @endphp

                                            <div class="d-flex align-items-center mb-4">
                                                <div class="me-3 d-flex align-items-center justify-content-center"
                                                     style="width: 70px; height: 70px; background: #f3e5ff; border-radius: 15px;">
                                                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                        <i class="bi bi-file-image" style="color: #9f7aea; font-size: 2.5rem;"></i>
                                                    @elseif($extension === 'pdf')
                                                        <i class="bi bi-file-pdf" style="color: #9f7aea; font-size: 2.5rem;"></i>
                                                    @else
                                                        <i class="bi bi-file-earmark-text" style="color: #9f7aea; font-size: 2.5rem;"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h5 class="mb-1" style="color: #2d3748;">Purchase Deed Document</h5>
                                                    <p class="text-muted small mb-0">
                                                        <i class="bi bi-calendar me-1"></i>
                                                        @if($createdAt)
                                                            Uploaded on {{ \Carbon\Carbon::parse($createdAt)->format('d M Y, h:i A') }}
                                                        @else
                                                            Upload date not available
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="row g-3 mb-4">
                                                <div class="col-md-4">
                                                    <span class="text-muted small d-block">Document Type</span>
                                                    <span style="color: #2d3748;">{{ strtoupper($extension) ?: 'N/A' }} Document</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-muted small d-block">Status</span>
                                                    <span class="badge" style="background: #c6f6d5; color: #22543d;">Verified</span>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2">
                                                @if($filePath)
                                                    <a href="{{ asset($filePath) }}" target="_blank" class="btn" style="background: #9f7aea; color: white; border: none;">
                                                        <i class="bi bi-eye me-2"></i>View
                                                    </a>
                                                    <a href="{{ asset($filePath) }}" download class="btn" style="background: white; color: #9f7aea; border: 1px solid #e9d5ff;">
                                                        <i class="bi bi-download me-2"></i>Download
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-file-earmark" style="font-size: 4rem; color: #e9d5ff;"></i>
                                </div>
                                <h5 class="text-muted">No Documents Uploaded</h5>
                                <p class="text-muted small">Upload your purchase deed document for verification.</p>
                                <button class="btn rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#uploadDocumentModal" style="background: #9f7aea; color: white; border: none;">
                                    <i class="bi bi-upload me-2"></i>Upload Document
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- ==================== SETTINGS TAB ==================== -->
                    <div class="tab-pane fade" id="settings" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card border-0" style="background: #faf5ff;">
                                    <div class="card-body p-4">
                                        <h5 class="mb-4" style="color: #553c9a;"><i class="bi bi-shield-lock me-2" style="color: #9f7aea;"></i>Change Password</h5>

                                        <form method="post" action="{{ route('password.update') }}">
                                            @csrf
                                            @method('put')

                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Current Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-0" style="color: #9f7aea;"><i class="bi bi-lock"></i></span>
                                                    <input type="password" class="form-control border-0" name="current_password" required style="background: white;">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-muted small">New Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-0" style="color: #9f7aea;"><i class="bi bi-lock-fill"></i></span>
                                                    <input type="password" class="form-control border-0" name="password" required style="background: white;">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Confirm Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-0" style="color: #9f7aea;"><i class="bi bi-lock-fill"></i></span>
                                                    <input type="password" class="form-control border-0" name="password_confirmation" required style="background: white;">
                                                </div>
                                            </div>

                                            <button type="submit" class="btn w-100 rounded-pill" style="background: #9f7aea; color: white; border: none;">
                                                <i class="bi bi-arrow-repeat me-2"></i>Update Password
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card border-0" style="background: #faf5ff;">
                                    <div class="card-body p-4">
                                        <h5 class="mb-4" style="color: #553c9a;"><i class="bi bi-bell me-2" style="color: #9f7aea;"></i>Notifications</h5>

                                        <form method="post" action="{{ route('profile.notifications.update') }}">
                                            @csrf
                                            @method('patch')

                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" name="email_notifications" id="emailNotif"
                                                       {{ $user->email_notifications ? 'checked' : '' }} style="background-color: #9f7aea; border-color: #9f7aea;">
                                                <label class="form-check-label text-muted" for="emailNotif">Email Notifications</label>
                                            </div>

                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" name="sms_notifications" id="smsNotif"
                                                       {{ $user->sms_notifications ? 'checked' : '' }} style="background-color: #9f7aea; border-color: #9f7aea;">
                                                <label class="form-check-label text-muted" for="smsNotif">SMS Notifications</label>
                                            </div>

                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_notifications" id="whatsappNotif"
                                                       {{ $user->whatsapp_notifications ? 'checked' : '' }} style="background-color: #9f7aea; border-color: #9f7aea;">
                                                <label class="form-check-label text-muted" for="whatsappNotif">WhatsApp Notifications</label>
                                            </div>

                                            <button type="submit" class="btn w-100 rounded-pill" style="background: #9f7aea; color: white; border: none;">
                                                <i class="bi bi-save me-2"></i>Save Preferences
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- ==================== MODALS ==================== -->

<!-- Update Profile Picture Modal -->
<div class="modal fade" id="updateProfilePicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="border-radius: 20px;">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #f3e5ff 0%, #e8d5ff 100%);">
                <h5 class="modal-title" style="color: #553c9a;">Update Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="{{ route('profile.update.picture') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="modal-body p-4">
                    <div class="text-center mb-3">
                        @php
                            $previewUrl = null;
                            if ($user->profilePicture && $user->profilePicture->file_path) {
                                $previewUrl = asset($user->profilePicture->file_path);
                            }
                        @endphp

                        @if($previewUrl)
                            <img src="{{ $previewUrl }}"
                                 id="preview-image"
                                 class="rounded-circle border"
                                 style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #e9d5ff !important;">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                 id="preview-image"
                                 style="width: 150px; height: 150px; background: linear-gradient(135deg, #f3e5ff 0%, #e8d5ff 100%);">
                                <i class="bi bi-person-fill" style="color: #9f7aea; font-size: 5rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Choose Image</label>
                        <input type="file" class="form-control border-0" name="profile_pic" accept="image/*" required onchange="previewImage(this)" style="background: #f5f0ff;">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #9f7aea; border: 1px solid #e9d5ff;">Cancel</button>
                    <button type="submit" class="btn" style="background: #9f7aea; color: white; border: none;">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Family Member Modal -->
<div class="modal fade" id="addFamilyMemberModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0" style="border-radius: 20px;">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #f3e5ff 0%, #e8d5ff 100%);">
                <h5 class="modal-title" style="color: #553c9a;"><i class="bi bi-person-plus-fill me-2"></i>Add Family Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="{{ route('profile.family.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Full Name *</label>
                            <input type="text" class="form-control border-0" name="name" required style="background: #f5f0ff;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Relationship *</label>
                            <select class="form-select border-0" name="relationship" required style="background: #f5f0ff;">
                                <option value="">Select</option>
                                <option value="spouse">Spouse</option>
                                <option value="son">Son</option>
                                <option value="daughter">Daughter</option>
                                <option value="father">Father</option>
                                <option value="mother">Mother</option>
                                <option value="brother">Brother</option>
                                <option value="sister">Sister</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Age</label>
                            <input type="number" class="form-control border-0" name="age" style="background: #f5f0ff;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Gender</label>
                            <select class="form-select border-0" name="gender" style="background: #f5f0ff;">
                                <option value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Emergency Contact</label>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="is_emergency_contact" value="1" style="border-color: #9f7aea;">
                                <label class="form-check-label text-muted">Mark as emergency</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Mobile Number</label>
                            <input type="text" class="form-control border-0" name="mobile" style="background: #f5f0ff;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Email</label>
                            <input type="email" class="form-control border-0" name="email" style="background: #f5f0ff;">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">Profile Picture</label>
                            <input type="file" class="form-control border-0" name="profile_pic" accept="image/*" style="background: #f5f0ff;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #9f7aea; border: 1px solid #e9d5ff;">Cancel</button>
                    <button type="submit" class="btn" style="background: #9f7aea; color: white; border: none;">Add Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Pet Modal -->
<div class="modal fade" id="addPetModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0" style="border-radius: 20px;">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #f3e5ff 0%, #e8d5ff 100%);">
                <h5 class="modal-title" style="color: #553c9a;"><i class="bi bi-heart-fill me-2"></i>Add Pet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="{{ route('profile.pets.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Pet Name *</label>
                            <input type="text" class="form-control border-0" name="name" required style="background: #f5f0ff;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Type *</label>
                            <select class="form-select border-0" name="type" required style="background: #f5f0ff;">
                                <option value="">Select</option>
                                <option value="dog">Dog</option>
                                <option value="cat">Cat</option>
                                <option value="bird">Bird</option>
                                <option value="fish">Fish</option>
                                <option value="rabbit">Rabbit</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Breed</label>
                            <input type="text" class="form-control border-0" name="breed" style="background: #f5f0ff;">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted">Age (years)</label>
                            <input type="number" class="form-control border-0" name="age" style="background: #f5f0ff;">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted">Color</label>
                            <input type="text" class="form-control border-0" name="color" style="background: #f5f0ff;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Registration Number</label>
                            <input type="text" class="form-control border-0" name="registration_number" style="background: #f5f0ff;">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">Vaccination Details</label>
                            <textarea class="form-control border-0" name="vaccination_details" rows="2" style="background: #f5f0ff;"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">Pet Picture</label>
                            <input type="file" class="form-control border-0" name="profile_pic" accept="image/*" style="background: #f5f0ff;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #9f7aea; border: 1px solid #e9d5ff;">Cancel</button>
                    <button type="submit" class="btn" style="background: #9f7aea; color: white; border: none;">Add Pet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Vehicle Modal -->
<div class="modal fade" id="addVehicleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0" style="border-radius: 20px;">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #f3e5ff 0%, #e8d5ff 100%);">
                <h5 class="modal-title" style="color: #553c9a;"><i class="bi bi-car-front-fill me-2"></i>Add Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="{{ route('profile.vehicles.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Vehicle Type *</label>
                            <select class="form-select border-0" name="type" required style="background: #f5f0ff;">
                                <option value="">Select</option>
                                <option value="car">Car</option>
                                <option value="bike">Bike</option>
                                <option value="scooter">Scooter</option>
                                <option value="cycle">Cycle</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Registration Number *</label>
                            <input type="text" class="form-control border-0" name="registration_number" required style="background: #f5f0ff;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Model</label>
                            <input type="text" class="form-control border-0" name="model" style="background: #f5f0ff;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Color</label>
                            <input type="text" class="form-control border-0" name="color" style="background: #f5f0ff;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Parking Slot</label>
                            <input type="text" class="form-control border-0" name="parking_slot_number" style="background: #f5f0ff;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Fuel Type</label>
                            <select class="form-select border-0" name="fuel_type" style="background: #f5f0ff;">
                                <option value="">Select</option>
                                <option value="petrol">Petrol</option>
                                <option value="diesel">Diesel</option>
                                <option value="electric">Electric</option>
                                <option value="cng">CNG</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Insurance Expiry</label>
                            <input type="date" class="form-control border-0" name="insurance_expiry" style="background: #f5f0ff;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Pollution Expiry</label>
                            <input type="date" class="form-control border-0" name="pollution_expiry" style="background: #f5f0ff;">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">RC Document</label>
                            <input type="file" class="form-control border-0" name="rc_document" accept=".pdf,image/*" style="background: #f5f0ff;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #9f7aea; border: 1px solid #e9d5ff;">Cancel</button>
                    <button type="submit" class="btn" style="background: #9f7aea; color: white; border: none;">Add Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Custom Styles */
    .profile-avatar-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-avatar-wrapper button {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .profile-avatar-wrapper:hover button {
        opacity: 1;
    }

    .nav-tabs .nav-link {
        color: #718096;
        font-weight: 500;
        padding: 1rem;
        border: none;
        border-bottom: 3px solid transparent;
    }

    .nav-tabs .nav-link:hover {
        border-bottom-color: #e9d5ff;
    }

    .nav-tabs .nav-link.active {
        color: #9f7aea;
        border-bottom-color: #9f7aea;
        background: transparent;
    }

    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(159, 122, 234, 0.1) !important;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 3px rgba(159, 122, 234, 0.1);
        border-color: #9f7aea !important;
    }

    .btn-purple {
        background: #9f7aea;
        color: white;
    }

    .btn-purple:hover {
        background: #8b5cf6;
        color: white;
    }

    .border-purple {
        border-color: #9f7aea !important;
    }

    .text-purple {
        color: #9f7aea !important;
    }

    .bg-purple-light {
        background: #faf5ff;
    }
</style>
@endpush

@push('scripts')
<script>
    // Preview image before upload
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('preview-image');
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                } else {
                    // Replace the div with an img
                    var img = document.createElement('img');
                    img.id = 'preview-image';
                    img.src = e.target.result;
                    img.className = 'rounded-circle border';
                    img.style.width = '150px';
                    img.style.height = '150px';
                    img.style.objectFit = 'cover';
                    img.style.border = '3px solid #e9d5ff';
                    preview.parentNode.replaceChild(img, preview);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto-hide success messages
    setTimeout(function() {
        document.querySelectorAll('.text-success').forEach(function(el) {
            el.style.display = 'none';
        });
    }, 5000);

    // Family Member Functions
    function editFamilyMember(id) {
        window.location.href = "{{ route('profile.family.edit', '') }}/" + id;
    }

    function deleteFamilyMember(id) {
        if (confirm('Are you sure you want to delete this family member?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('profile.family.destroy', '') }}/" + id;
            form.innerHTML = '@csrf @method('DELETE')';
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Pet Functions
    function editPet(id) {
        window.location.href = "{{ route('profile.pets.edit', '') }}/" + id;
    }

    function deletePet(id) {
        if (confirm('Are you sure you want to delete this pet?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('profile.pets.destroy', '') }}/" + id;
            form.innerHTML = '@csrf @method('DELETE')';
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Vehicle Functions
    function editVehicle(id) {
        window.location.href = "{{ route('profile.vehicles.edit', '') }}/" + id;
    }

    function deleteVehicle(id) {
        if (confirm('Are you sure you want to delete this vehicle?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('profile.vehicles.destroy', '') }}/" + id;
            form.innerHTML = '@csrf @method('DELETE')';
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush

@endsection
