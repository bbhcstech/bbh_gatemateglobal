@extends('admin.layout.app')

@section('title', 'Vehicle Management')

@section('content')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Add Domestic Help / Vendor</h5>
    </div>

    <div class="card-body">
        <form method="POST"
      action="{{ route('domestic-helps.store') }}"
      enctype="multipart/form-data" autocomplete="off">
    @csrf

    <div class="mb-3">
        <label class="form-label">Type<span class="text-danger">*</span></label>
        <select name="type" class="form-select" required>
            <option value="">Select</option>
            <option value="domestic_help">Domestic Help</option>
            <option value="vendor">Vendor</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Name<span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Phone<span class="text-danger">*</span></label>
        <input type="text" name="phone" class="form-control"  maxlength="10"
    oninput="this.value=this.value.replace(/[^0-9]/g,'')"  placeholder="Enter 10 digit mobile number" required>
    </div>

    <div class="mb-3">
        <label>Service</label>
        <input type="text" name="service" class="form-control"
               placeholder="Maid / Cook / Milkman">
    </div>

    <div class="mb-3">
        <label>Vehicle No</label>
        <input type="text" name="vehicle_number" class="form-control">
    </div>

    <!-- ✅ Photo Upload -->
    <div class="mb-3">
        <label>Photo</label>
        <input type="file"
               name="photo"
               class="form-control"
               accept="image/*">
        <small class="text-muted">JPG, PNG (Max 2MB)</small>
    </div>

    <!-- ✅ ID / Document Upload -->
    <div class="mb-3">
        <label>Government ID / Document</label>
        <input type="file"
               name="document"
               class="form-control"
               accept=".pdf,.jpg,.jpeg,.png">
        <small class="text-muted">Aadhar / Voter / PDF (Max 5MB)</small>
    </div>

    <div class="mb-3">
        <label>Notes</label>
        <textarea name="notes" class="form-control"></textarea>
    </div>

    <button class="btn btn-primary">Save</button>
</form>

    </div>
</div>
@endsection
