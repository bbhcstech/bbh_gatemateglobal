@extends('admin.layout.app')

@section('title', 'Edit Visitor Pre-Approval')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">✏ Edit Visitor Pre-Approval</h5>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger m-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body">

            <form action="{{ route('visitor-preapproval.update', $approval->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- Visitor Name --}}
                <div class="mb-3">
                    <label class="form-label">Visitor Name</label>
                    <input type="text" 
                           name="name" 
                           class="form-control" 
                           value="{{ old('name', $approval->name) }}"
                           required>
                </div>

                {{-- Phone Number --}}
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" 
                           name="phone" 
                           class="form-control" 
                           value="{{ old('phone', $approval->phone) }}"
                           required>
                </div>

                {{-- Existing Image Preview --}}
                <div class="mb-3">
                    <label class="form-label">Visitor Photo</label>
                    <input type="file" name="image" class="form-control">

                    @if($approval->image)
                        <div class="mt-2">
                            <img src="{{ asset($approval->image) }}" 
                                 width="100" 
                                 class="img-thumbnail">
                        </div>
                    @endif
                </div>

                {{-- Purpose --}}
                <div class="mb-3">
                    <label class="form-label">Purpose of Visit</label>
                    <textarea name="purpose" 
                              class="form-control" 
                              rows="3" 
                              required>{{ old('purpose', $approval->purpose) }}</textarea>
                </div>

                {{-- Visit Date --}}
                <div class="mb-3">
                    <label class="form-label">Visit Date <span class="text-danger">*</span></label>
                    <input type="date"
                           name="visit_date"
                           class="form-control"
                           value="{{ old('visit_date', $approval->visit_date) }}"
                           required>
                </div>

                {{-- Expected Time --}}
                <div class="mb-3">
                    <label class="form-label">Expected Time <span class="text-danger">*</span></label>
                    <input type="time"
                           name="expected_time"
                           class="form-control"
                           value="{{ old('expected_time', $approval->expected_time) }}"
                           required>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('visitor-preapproval.index') }}" 
                       class="btn btn-outline-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-success px-4">
                        Update Visitor
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
