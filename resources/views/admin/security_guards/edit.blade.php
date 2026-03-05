@extends('admin.layout.app')

@section('title', 'Edit Security Guard')

@section('content')
<div class="container-fluid">

    <h4 class="mb-3">Edit Security Guard</h4>

    <div class="card">
        <form method="POST" action="{{ route('security-guards.update', $guard->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>First Name *</label>
                        <input type="text" name="first_name"
                               class="form-control"
                               value="{{ $guard->first_name }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Last Name *</label>
                        <input type="text" name="last_name"
                               class="form-control"
                               value="{{ $guard->last_name }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email"
                               class="form-control"
                               value="{{ $guard->email }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ $guard->phone }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Shift *</label>
                        <select name="shift" class="form-control" required>
                            <option value="Morning" {{ $guard->shift == 'Morning' ? 'selected' : '' }}>Morning</option>
                            <option value="Evening" {{ $guard->shift == 'Evening' ? 'selected' : '' }}>Evening</option>
                            <option value="Night" {{ $guard->shift == 'Night' ? 'selected' : '' }}>Night</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox"
                                   name="is_active"
                                   {{ $guard->is_active ? 'checked' : '' }}>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">💾 Update</button>
                <a href="{{ route('security-guards.index') }}" class="btn btn-secondary">✖ Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
