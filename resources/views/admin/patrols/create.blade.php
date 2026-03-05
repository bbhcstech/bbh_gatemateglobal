{{-- resources/views/admin/patrols/create.blade.php --}}
@extends('admin.layout.app')

@section('title','Add Patrol Log')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Add Patrol Log</h5>
    </div>

    <form method="POST" action="{{ route('patrols.store') }}">
        @csrf
        <div class="card-body row g-3">

            <div class="col-md-6">
                <label class="form-label">Security Guard *</label>
                <select name="security_guard_id" class="form-select">
                    <option value="">Select Guard</option>
                    @foreach($guards as $guard)
                        <option value="{{ $guard->id }}">{{ $guard->first_name }} {{ $guard->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Zone *</label>
                <select name="zone_id" class="form-select">
                    <option value="">Select Zone</option>
                    @foreach($zones as $zone)
                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Start Time *</label>
                <input type="datetime-local" name="start_time" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">End Time</label>
                <input type="datetime-local" name="end_time" class="form-control">
            </div>

            <div class="col-md-12">
                <label class="form-label">Checkpoints *</label>
                <textarea name="checkpoints" class="form-control"></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Status *</label>
                <select name="status" class="form-select">
                    <option value="Scheduled">Scheduled</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>

        </div>

        <div class="card-footer text-end">
            <button class="btn btn-primary">💾 Save</button>
            <a href="{{ route('patrols.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
