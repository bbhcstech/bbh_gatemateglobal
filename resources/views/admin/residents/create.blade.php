@extends('admin.layout.app')

@section('title', 'Home Page')

@section('content')
<div class="container">
<div class="card shadow-sm">
<div class="card-header">Add Resident</div>
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

<form method="POST" action="{{ route('residents.store') }}">
@csrf

<input class="form-control mb-2" name="name" placeholder="Resident Name" required>

{{-- Tower --}}
<select id="tower" name="tower_id" class="form-control mb-1" required>
    <option value="">Select Tower</option>
    @foreach($towers as $tower)
        <option value="{{ $tower->id }}" {{ old('tower_id') == $tower->id ? 'selected' : '' }}>
            {{ $tower->name }}
        </option>
    @endforeach
</select>
@error('tower_id')
    <small class="text-danger">{{ $message }}</small>
@enderror

{{-- Floor --}}
<select id="floor" name="floor_id" class="form-control mb-1" required>
    <option value="">Select Floor</option>
</select>
@error('floor_id')
    <small class="text-danger">{{ $message }}</small>
@enderror

{{-- Flat --}}
<select name="flat_id" id="flat" class="form-control mb-1" required>
    <option value="">Select Flat</option>
</select>
@error('flat_id')
    <small class="text-danger">{{ $message }}</small>
@enderror


<input class="form-control mb-2" name="phone"placeholder="Enter 10 digit mobile number" placeholder="Phone" required>
@error('phone')
    <small class="text-danger">{{ $message }}</small>
@enderror
<input class="form-control mb-2" name="email" placeholder="Email">
@error('email')
    <small class="text-danger">{{ $message }}</small>
@enderror

<select name="type" class="form-control mb-3">
    <option value="owner">Owner</option>
    <option value="tenant">Tenant</option>
</select>
@error('type')
    <small class="text-danger">{{ $message }}</small>
@enderror
<button class="btn btn-success">Save</button>
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

    tower.addEventListener('change', function () {
        if (!this.value) return;

        fetch(`{{ url('/get-floors') }}/${this.value}`)
            .then(res => res.json())
            .then(data => {
                floor.innerHTML = '<option value="">Select Floor</option>';
                flat.innerHTML  = '<option value="">Select Flat</option>';

                data.forEach(f => {
                    floor.innerHTML += `<option value="${f.id}">Floor ${f.floor_no}</option>`;
                });
            });
    });

    floor.addEventListener('change', function () {
        if (!this.value) return;

        fetch(`{{ url('/get-flats') }}/${this.value}`)
            .then(res => res.json())
            .then(data => {
                flat.innerHTML = '<option value="">Select Flat</option>';

                data.forEach(f => {
                    flat.innerHTML += `<option value="${f.id}">${f.flat_no}</option>`;
                });
            });
    });

});
</script>
@endpush
