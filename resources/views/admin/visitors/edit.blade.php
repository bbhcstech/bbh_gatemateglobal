@extends('admin.layout.app')

@section('title', 'Home Page')

@section('content')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-warning text-dark rounded-top-4">
                    <h5 class="mb-0">✏️ Edit Visitor</h5>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('visitors.update',$visitor->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Visitor Name</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ $visitor->name }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control"
                                       value="{{ $visitor->phone }}" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Resident</label>
                                <select name="resident_id" class="form-select" required>
                                    @foreach($residents as $resident)
                                        <option value="{{ $resident->id }}"
                                            {{ $visitor->resident_id == $resident->id ? 'selected' : '' }}>
                                            {{ $resident->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Expected Arrival</label>
                                <input type="datetime-local" name="expected_arrival"
                                       class="form-control"
                                       value="{{ \Carbon\Carbon::parse($visitor->expected_arrival)->format('Y-m-d\TH:i') }}"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Vehicle Number</label>
                                <input type="text" name="vehicle_number" class="form-control"
                                       value="{{ $visitor->vehicle_number }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Visitor Photo</label>
                                <input type="file" name="image" class="form-control">
                                @if($visitor->image)
                                    <img src="{{ asset('storage/'.$visitor->image) }}"
                                         class="mt-2 rounded border" width="120">
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Purpose of Visit</label>
                                <textarea name="purpose" class="form-control" rows="3" required>{{ $visitor->purpose }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="2">{{ $visitor->notes }}</textarea>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('visitors.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-warning px-4">Update Visitor</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
