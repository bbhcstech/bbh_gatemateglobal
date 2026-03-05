@extends('admin.layout.app')

@section('title', 'Add Security Guard')

@section('content')
<div class="container-fluid">
    <a href="{{ url()->previous() }}" class="mb-3 d-inline-block">Home</a>

    <div class="card">
        <div class="card-header">
            <h5>Add Security Guard</h5>
        </div>

        <form method="POST" action="{{ route('security-guards.store') }}">
            @csrf

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>First Name *</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Last Name *</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Optional">
                        <small class="text-muted">
                            If provided, must be unique across all users
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="Optional">
                    </div>

                    <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Shift *</label>
                                <select class="form-select" name="shift" required="">
                                    <option value="">Select Shift</option>
                                    <option value="morning">Morning (6AM - 2PM)</option>
                                    <option value="afternoon">Afternoon (2PM - 10PM)</option>
                                    <option value="night">Night (10PM - 6AM)</option>
                                </select>
                            </div>
                        </div>

                    <div class="col-md-6 mb-3 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_active" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="fa fa-info-circle"></i>
                    A username will be automatically generated, and a temporary password will be created for this security guard.
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">
                    💾 Save
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    ✖ Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
