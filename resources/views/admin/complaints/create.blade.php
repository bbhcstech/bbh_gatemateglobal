@extends('admin.layout.app')

@section('title', isset($complaint) ? 'Edit Complaint' : 'Raise Complaint')

@section('content')
<div class="container">
    <div class="card shadow-sm col-md-6 mx-auto">
        <div class="card-body p-4">
            <h4 class="mb-3">{{ isset($complaint) ? 'Edit' : 'Raise' }} Complaint</h4>


             

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <form method="POST" 
                  action="{{ isset($complaint) ? route('complaints.update', $complaint) : route('complaints.store') }}">
                @csrf
                @isset($complaint) @method('PUT') @endisset

                <div class="mb-3">
                    <label class="form-label fw-semibold">Resident</label>
                    <select name="resident_id" class="form-select" required>
                        <option value="">-- Select Resident --</option>
                        @foreach($residents as $resident)
                        <option value="{{ $resident->id }}" 
                            {{ old('resident_id', $complaint->resident_id ?? '') == $resident->id ? 'selected' : '' }}>
                            {{ $resident->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('resident_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Complaint Type</label>
                    <select name="type" class="form-select" required>
                        @php
                            $types = ['Helping', 'Maintenance', 'Security'];
                        @endphp
                        <option value="">-- Select Type --</option>
                        @foreach($types as $type)
                        <option value="{{ $type }}"
                            {{ old('type', $complaint->type ?? '') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                        @endforeach
                    </select>
                    @error('type')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $complaint->description ?? '') }}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                @isset($complaint)
<div class="mb-3">
    <label class="form-label fw-semibold">Status</label>
    <select name="status" class="form-select" 
            {{ auth()->user()->role !== 'admin' ? 'disabled' : '' }} required>
        @php
            $statuses = ['Pending', 'In Progress', 'Resolved'];
        @endphp
        @foreach($statuses as $status)
            <option value="{{ $status }}" {{ old('status', $complaint->status) == $status ? 'selected' : '' }}>
                {{ $status }}
            </option>
        @endforeach
    </select>

    @if(auth()->user()->role !== 'admin')
        <!-- Include hidden input so resident can submit without changing status -->
        <input type="hidden" name="status" value="{{ $complaint->status }}">
    @endif
</div>
@endisset


                <div class="text-end">
                    <button class="btn btn-success rounded-pill px-4">{{ isset($complaint) ? 'Update' : 'Raise' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
