@extends('admin.layout.app')

@section('title', 'Edit Resident')

@section('content')
<div class="container">
<div class="card shadow-sm">
<div class="card-header">Edit Resident</div>
<div class="card-body">


@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('residents.update', $resident->id) }}">
@csrf
@method('PUT')

<input class="form-control mb-2"
       name="name"
       value="{{ old('name', $resident->name) }}"
       placeholder="Resident Name"
       required>

{{-- Tower --}}
<select id="tower" name="tower_id" class="form-control mb-2">
    <option value="">Select Tower</option>
    @foreach($towers as $tower)
        <option value="{{ $tower->id }}"
            {{ $resident->flat?->floor?->tower_id == $tower->id ? 'selected' : '' }}>
            {{ $tower->name }}
        </option>
    @endforeach
</select>
@error('tower_id')
    <small class="text-danger">{{ $message }}</small>
@enderror

{{-- Floor --}}
<select id="floor" name="floor_id" class="form-control mb-2">
    <option value="">Select Floor</option>
</select>
@error('floor_id')
    <small class="text-danger">{{ $message }}</small>
@enderror
{{-- Flat --}}
<select name="flat_id" id="flat" class="form-control mb-2" required>
    <option value="">Select Flat</option>
</select>
@error('flat_id')
    <small class="text-danger">{{ $message }}</small>
@enderror
<input class="form-control mb-2"
       name="phone"
       value="{{ old('phone', $resident->phone) }}"
       placeholder="Phone"
        placeholder="Enter 10 digit mobile number"
       required>
@error('phone')
    <small class="text-danger">{{ $message }}</small>
@enderror
<input class="form-control mb-2"
       name="email"
       value="{{ old('email', $resident->email) }}"
       placeholder="Email">
@error('email')
    <small class="text-danger">{{ $message }}</small>
@enderror
<select name="type" class="form-control mb-3">
    <option value="owner" {{ $resident->type == 'owner' ? 'selected' : '' }}>Owner</option>
    <option value="tenant" {{ $resident->type == 'tenant' ? 'selected' : '' }}>Tenant</option>
</select>
@error('type')
    <small class="text-danger">{{ $message }}</small>
@enderror
<button class="btn btn-primary">Update</button>
<a href="{{ route('residents.index') }}" class="btn btn-secondary">Cancel</a>

</form>

</div>
</div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const tower = document.getElementById('tower');
    const floor = document.getElementById('floor');
    const flat  = document.getElementById('flat');

    const selectedFloorId = "{{ $resident->flat->floor_id }}";
    const selectedFlatId  = "{{ $resident->flat_id }}";

    function loadFloors(towerId, selectedFloor = null) {
        fetch(`{{ url('/get-floors') }}/${towerId}`)
            .then(res => res.json())
            .then(data => {
                floor.innerHTML = '<option value="">Select Floor</option>';
                data.forEach(f => {
                    floor.innerHTML += `
                        <option value="${f.id}" ${selectedFloor == f.id ? 'selected' : ''}>
                            Floor ${f.floor_no}
                        </option>`;
                });
            });
    }

    function loadFlats(floorId, selectedFlat = null) {
        fetch(`{{ url('/get-flats') }}/${floorId}`)
            .then(res => res.json())
            .then(data => {
                flat.innerHTML = '<option value="">Select Flat</option>';
                data.forEach(f => {
                    flat.innerHTML += `
                        <option value="${f.id}" ${selectedFlat == f.id ? 'selected' : ''}>
                            ${f.flat_no}
                        </option>`;
                });
            });
    }

    // Initial load for edit
    if (tower.value) {
        loadFloors(tower.value, selectedFloorId);
        loadFlats(selectedFloorId, selectedFlatId);
    }

    tower.addEventListener('change', function () {
        loadFloors(this.value);
        flat.innerHTML = '<option value="">Select Flat</option>';
    });

    floor.addEventListener('change', function () {
        loadFlats(this.value);
    });

});
</script>
@endpush
