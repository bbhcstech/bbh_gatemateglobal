@extends('admin.layout.app')

@section('title', 'Profile')

@section('content')
<main id="main" class="main">
  <div class="container mt-4">

    <!-- Page Title & Breadcrumb -->
    <div class="pagetitle mb-4">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            @if(Auth::check())
              @if(Auth::user()->role === 'admin')
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
                  <img src="admin/assets/img/logo.png" alt="" class="me-2" style="height:24px;">
                  Micro Poem Admin
                </a>
              @elseif(Auth::user()->role === 'manager')
                <a href="{{ route('manager.dashboard') }}" class="d-flex align-items-center">
                  <img src="admin/assets/img/logo.png" alt="" class="me-2" style="height:24px;">
                  Micro Poem Manager
                </a>
              @endif
            @endif
          </li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div>

    <!-- Profile Section -->
    <section class="section profile">
      <div class="row justify-content-center">
        <div class="col-xl-10">

          <!-- Modern Card -->
          <div class="card shadow-lg rounded-2xl border-0 overflow-hidden">
            <div class="card-body p-0">
              <div class="d-flex flex-column flex-md-row">

                <!-- Left: Profile Picture -->
                <div class="md:w-1/4 bg-indigo-500 text-white text-center p-6 d-flex flex-column align-items-center justify-content-start">
                  <div class="w-24 h-24 rounded-full overflow-hidden shadow-lg mb-3">
                    <img src="{{ $user->profile_pic ? asset($user->profile_pic) : 'admin/assets/img/default-avatar.png' }}" class="w-24 h-24 object-cover rounded-full">
                  </div>
                  <h2 class="fw-bold mb-1">{{ $user->name }}</h2>
                  <p class="small opacity-75">{{ $user->email }}</p>
                  <p class="small">Role: <strong>{{ ucfirst($user->role) }}</strong></p>
                </div>

                <!-- Right: Form -->
                <div class="md:w-3/4 bg-white dark:bg-gray-900 p-6">
                  <ul class="nav nav-tabs nav-tabs-bordered mb-4">
                    <li class="nav-item">
                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Edit Profile</button>
                    </li>
                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                    </li>
                  </ul>

                  <div class="tab-content">

                    <!-- Edit Profile Tab -->
                    <div class="tab-pane fade show active" id="profile-overview">

                      <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

                      <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        @method('patch')

                        <!-- Name -->
                        <div class="col-md-6">
                          <x-input-label for="name" :value="__('Name')" class="fw-semibold"/>
                          <x-text-input id="name" name="name" type="text" class="form-control mt-1 rounded-3" :value="old('name', $user->name)" required autofocus autocomplete="name"/>
                          <x-input-error class="mt-1 text-danger" :messages="$errors->get('name')" />
                        </div>

                        <!-- Email (large input) -->
                        <div class="col-md-12">
                          <x-input-label for="email" :value="__('Email')" class="fw-semibold"/>
                          <x-text-input id="email" name="email" type="email" class="form-control mt-1 rounded-3" :value="old('email', $user->email)" required autocomplete="username"/>
                          <x-input-error class="mt-1 text-danger" :messages="$errors->get('email')" />
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-6">
                          <x-input-label for="mobile" value="Mobile Number" class="fw-semibold"/>
                          <x-text-input id="mobile" name="mobile" type="text" class="form-control mt-1 rounded-3" value="{{ old('mobile', $user->mobile) }}" required/>
                          <x-input-error class="mt-1 text-danger" :messages="$errors->get('mobile')" />
                        </div>

                        <!-- WhatsApp -->
                        <div class="col-md-6">
                          <x-input-label for="whatsapp_no" value="WhatsApp Number" class="fw-semibold"/>
                          <x-text-input id="whatsapp_no" name="whatsapp_no" type="text" class="form-control mt-1 rounded-3" value="{{ old('whatsapp_no', $user->whatsapp_no) }}"/>
                          <x-input-error class="mt-1 text-danger" :messages="$errors->get('whatsapp_no')" />
                        </div>

                        <!-- Profile Picture -->
                        <div class="col-md-6">
                            <x-input-label for="profile_pic" value="Profile Picture" class="fw-semibold"/>
                        
                            <input type="file"
                                   name="profile_pic"
                                   class="form-control mt-1 rounded-3"
                                   accept="image/*"/>
                        
                            {{-- Preview --}}
                            @if(optional($user->profilePicture)->file_path)
                                <img src="{{ asset($user->profilePicture->file_path) }}"
                                     class="img-thumbnail mt-2"
                                     style="width:120px;height:120px;object-fit:cover;">
                            @endif
                        
                            <x-input-error class="mt-1 text-danger" :messages="$errors->get('profile_pic')"/>
                        </div>

                        <!-- Documents -->
                      <div class="col-md-6">
                        <x-input-label for="documents" value="Documents" class="fw-semibold"/>
                    
                        <input type="file"
                               name="documents"
                               class="form-control mt-1 rounded-3"
                               accept="image/*,.pdf">
                    
                        {{-- Document link --}}
                        @if(optional($user->document)->file_path)
                            <a href="{{ asset($user->document->file_path) }}"
                               target="_blank"
                               class="text-primary mt-1 d-block small">
                                View Uploaded Document
                            </a>
                        @endif
                    
                        <x-input-error class="mt-1 text-danger" :messages="$errors->get('documents')"/>
                    </div>

                        <!-- Save Button -->
                        <div class="col-12 mt-3">
                          <button type="submit" class="btn btn-gradient px-5 py-2 rounded-pill text-white fw-bold" style="background: linear-gradient(to right, #6366F1, #8B5CF6);">
                            Save Changes
                          </button>
                          @if (session('status') === 'profile-updated')
                            <span class="ms-3 text-success">Saved!</span>
                          @endif
                          
                          <a href="{{ url('/profile') }}" class="btn btn-secondary">
                        Cancel
                          </a>
                        </div>

                      </form>
                    </div>
                    <!-- End Edit Profile Tab -->

                    <!-- Settings Tab -->
                    <div class="tab-pane fade pt-3" id="profile-settings">
                      <div class="p-4 bg-white dark:bg-gray-900 rounded-3 shadow mb-3">
                        @include('profile.partials.update-password-form')
                      </div>
                      <!--<div class="p-4 bg-white dark:bg-gray-900 rounded-3 shadow">-->
                      <!--  @include('profile.partials.delete-user-form')-->
                      <!--</div>-->
                    </div>

                  </div> <!-- End Tab Content -->

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

  </div>
</main>
@endsection
