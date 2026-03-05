@extends('admin.layout.app')

@section('title', 'Create User')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Create User</h5>
    </div>
    
    

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="card-body row g-3">

            <div class="col-md-6">
                <label class="form-label">Name *</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email </label>
                <input type="email" name="email" class="form-control" >
            </div>
            
            <div class="col-md-6">
                <label class="form-label">Mobile <span class="text-danger">*</span></label>
                <input
                        type="tel"
                        name="mobile"
                        class="form-control"
                        maxlength="10"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                        required
                    >
                @error('mobile')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <div class="col-md-6">
                <label class="form-label">Select Role *</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Select Role --</option>
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Password</label>
                <input type="text" class="form-control" value="Password@123" disabled>
                <small class="text-muted">System generated password</small>
            </div>

        </div>

        <div class="card-footer text-end">
            <button class="btn btn-primary">Create User</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
