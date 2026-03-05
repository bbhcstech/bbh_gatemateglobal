@extends('admin.layout.app')

@section('content')
<h4>Schedule Vendor Visit</h4>

<form method="POST" action="{{ route('vendor-visits.store') }}">
    @csrf
    <div class="mb-3">
        <label>Vendor</label>
        <select name="vendor_id" class="form-control" id="vendor-select" required>
            <option value="">Select Vendor</option>
            @foreach($vendors as $vendor)
                <option value="{{ $vendor->vendor_id }}">
                    {{ $vendor->name }} ({{ $vendor->service_type }})
                </option>
            @endforeach
            <option value="new">+ Add New Vendor</option>
        </select>
    </div>

    <!-- Hidden fields for new vendor -->
    <div id="new-vendor-fields" style="display: none;">
        <div class="mb-3">
            <label>Vendor Name</label>
            <input type="text" name="new_vendor_name" class="form-control">
        </div>
        <div class="mb-3">
            <label>Service Type</label>
            <input type="text" name="new_vendor_service" class="form-control">
        </div>
        <div class="mb-3">
            <label>Mobile</label>
            <input type="text" name="new_vendor_mobile" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        <label>Resident</label>
        <select name="resident_id" class="form-control" required>
            <option value="">Select Resident</option>
            @foreach($residents as $resident)
                <option value="{{ $resident->id }}">{{ $resident->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="visit_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Time</label>
        <input type="time" name="time" class="form-control" required>
    </div>

    <button class="btn btn-success">Schedule Visit</button>
</form>

@endsection
@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const vendorSelect = document.getElementById('vendor-select');
        const newVendorFields = document.getElementById('new-vendor-fields');

        vendorSelect.addEventListener('change', function() {
            if(this.value === 'new') {
                newVendorFields.style.display = 'block';
                newVendorFields.querySelectorAll('input').forEach(i => i.required = true);
            } else {
                newVendorFields.style.display = 'none';
                newVendorFields.querySelectorAll('input').forEach(i => i.required = false);
            }
        });
    });
</script>
@endpush
