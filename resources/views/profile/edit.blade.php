@extends('admin.layout.app')

@section('title', 'Profile Page')

@section('content')
<main id="main" class="main">
    <div class="container mt-4">

        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        @if(Auth::check())
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            @elseif(Auth::user()->role === 'manager')
                                <a href="{{ route('manager.dashboard') }}">Dashboard</a>
                            @endif
                        @endif
                    </li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <!-- Left Column - Profile Image Card -->
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            @if(isset($user->profilePicture) && $user->profilePicture->file_path)
                                <img src="{{ asset($user->profilePicture->file_path) }}"
                                     alt="Profile"
                                     class="rounded-circle"
                                     style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #9f7aea;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 150px; height: 150px; background: linear-gradient(135deg, #b794f4 0%, #9f7aea 100%); color: white; font-size: 4rem; border: 4px solid #9f7aea;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif

                            <h2 class="mt-3" style="color: #2d3748;">{{ $user->name }}</h2>
                            <p class="text-muted mb-1">{{ $user->email }}</p>
                            <p class="text-muted small">
                                <i class="bi bi-telephone me-1" style="color: #9f7aea;"></i>{{ $user->mobile }}
                            </p>

                            <!-- Upload Button - Triggers Modal -->
                            <button class="btn btn-sm rounded-pill mt-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#updateProfilePicModal"
                                    style="background: #9f7aea; color: white; padding: 8px 20px;">
                                <i class="bi bi-camera me-2"></i>Update Photo
                            </button>
                        </div>
                    </div>
                </div><!-- End Left Column -->

                <!-- Right Column - Profile Forms -->
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">
                                        <i class="bi bi-pencil-square me-2" style="color: #9f7aea;"></i>Edit Profile
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">
                                        <i class="bi bi-gear me-2" style="color: #9f7aea;"></i>Settings
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content pt-4">
                                <!-- Edit Profile Tab -->
                                <div class="tab-pane fade show active" id="profile-overview">
                                    <div class="p-3">
                                        @include('profile.partials.update-profile-information-form')
                                    </div>
                                </div>

                                <!-- Settings Tab -->
                                <div class="tab-pane fade" id="profile-settings">
                                    <div class="p-3">
                                        <div class="mb-4">
                                            <h5 class="mb-3" style="color: #553c9a;">Change Password</h5>
                                            @include('profile.partials.update-password-form')
                                        </div>
                                        <hr>
                                        <div class="mt-4">
                                            <h5 class="mb-3" style="color: #dc3545;">Delete Account</h5>
                                            @include('profile.partials.delete-user-form')
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Tab Content -->
                        </div>
                    </div>
                </div><!-- End Right Column -->
            </div>
        </section>
    </div>
</main><!-- End #main -->

<!-- Profile Picture Upload Modal -->
<div class="modal fade" id="updateProfilePicModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #f3e5ff;">
                <h5 class="modal-title" style="color: #553c9a;">
                    <i class="bi bi-camera-fill me-2" style="color: #9f7aea;"></i>
                    Update Profile Picture
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.picture.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-3">
                        @if(isset($user->profilePicture) && $user->profilePicture->file_path)
                            <img src="{{ asset($user->profilePicture->file_path) }}"
                                 class="rounded-circle mb-3"
                                 style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #9f7aea;">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Choose New Image</label>
                        <input type="file" class="form-control" name="profile_pic" accept="image/*" required>
                        <small class="text-muted">Maximum file size: 5MB (JPG, PNG, GIF)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background: #9f7aea; color: white;">
                        <i class="bi bi-upload me-2"></i>Upload Photo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('status') === 'profile-picture-updated')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Profile picture updated successfully.',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: true
        });
    </script>
@endif

@endsection
