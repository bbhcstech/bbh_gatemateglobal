@extends('admin.layout.app')

@section('title', 'Add Help Attendance')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>➕ Add Help Attendance</h5>
        <a href="{{ route('help.attendance.index') }}" class="btn btn-secondary btn-sm">
            Back
        </a>
    </div>

    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('help.attendance.store') }}">
            @csrf

            <div class="mb-3">
                <label class="fw-bold">Help ID</label>
                <input type="number" name="help_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Entry Time</label>
                <input type="time" name="entry_time" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Exit Time</label>
                <input type="time" name="exit_time" class="form-control">
            </div>

            <button class="btn btn-success">
                💾 Save Attendance
            </button>
        </form>

    </div>
</div>
@endsection
