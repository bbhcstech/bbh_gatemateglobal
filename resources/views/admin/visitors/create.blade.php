@extends('admin.layout.app')

@section('title', 'Home Page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0">➕ Add New Visitor</h5>
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
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('visitors.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Visitor Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Resident</label>
                                <select name="resident_id" class="form-select" required>
                                    <option value="">Select Resident</option>
                                    @foreach($residents as $resident)
                                        <option value="{{ $resident->id }}">{{ $resident->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Expected Arrival</label>
                                <input type="datetime-local" name="expected_arrival" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Vehicle Number</label>
                                <input type="text" name="vehicle_number" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Visitor Photo</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Purpose of Visit</label>
                                <textarea name="purpose" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('visitors.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success px-4">Save Visitor</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
