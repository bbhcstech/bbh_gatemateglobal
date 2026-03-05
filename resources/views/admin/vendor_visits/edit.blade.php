@extends('admin.layout.app')

@section('content')
<h4>Edit Vendor Visit</h4>

<form method="POST" action="{{ route('vendor-visits.update', $vendorVisit->visit_id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Vendor</label>
        <select name="vendor_id" class="form-control" required>
            <option value="">Select Vendor</option>
            @foreach($vendors as $vendor)
                <option value="{{ $vendor->vendor_id }}"
                    {{ $vendorVisit->vendor_id == $vendor->vendor_id ? 'selected' : '' }}>
                    {{ $vendor->name }} ({{ $vendor->service_type }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Resident</label>
        <select name="resident_id" class="form-control" required>
            <option value="">Select Resident</option>
            @foreach($residents as $resident)
                <option value="{{ $resident->id }}"
                    {{ $vendorVisit->resident_id == $resident->id ? 'selected' : '' }}>
                    {{ $resident->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Visit Date</label>
        <input type="date" name="visit_date" class="form-control"
               value="{{ $vendorVisit->visit_date }}" required>
    </div>

    <div class="mb-3">
        <label>Visit Time</label>
        <input type="time" name="time" class="form-control"
               value="{{ $vendorVisit->time }}" required>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            @foreach(['Scheduled', 'In', 'Out', 'Cancelled'] as $status)
                <option value="{{ $status }}"
                    {{ $vendorVisit->status == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success">Update Visit</button>
    <a href="{{ route('vendor-visits.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
