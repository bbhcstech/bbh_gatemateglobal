@extends('admin.layout.app')

@section('title','Dynamic Tower Entry')

@section('content')
<div class="card">
    <div class="card-header">🏢 Dynamic Tower / Floor / Flat Entry</div>


@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="card-body">
        <form method="POST" action="{{ route('towers.store.dynamic') }}">
            @csrf

            <div class="mb-3">
                <label class="fw-bold">Tower Name</label>
                <input type="text" name="tower_name" class="form-control" required>
            </div>

            <div id="floor-wrapper"></div>

            <button type="button" class="btn btn-primary mb-3" onclick="addFloor()">
                ➕ Add Floor
            </button>

            <br>

            <button type="submit" class="btn btn-success">
                💾 Save Tower Structure
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">📋 Tower Listing</div>

    <div class="card-body">
        @forelse($towers as $tower)
            <div class="border rounded p-3 mb-3">

                <!-- 🔹 PUT EDIT/DELETE BLOCK HERE -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="text-primary mb-0">🏢 {{ $tower->name }}</h5>

                    <div>
                        <a href="{{ route('towers.edit', $tower->id) }}"
                           class="btn btn-sm btn-warning me-1">
                            ✏️ Edit
                        </a>

                       @if($tower->floors()->count() === 0)
                            <form method="POST"
                                  action="{{ route('towers.destroy', $tower->id) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this tower?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑 Delete</button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-secondary" disabled
                                title="Tower structure already created">
                                🔒 Cannot Delete
                            </button>
                        @endif

                    </div>
                </div>

                <!-- Floors & Flats -->
                @foreach($tower->floors as $floor)
                    <div class="ms-3">
                        <strong>Floor {{ $floor->floor_no }}</strong>

                       <div class="ms-4 mt-1">
@foreach($floor->flats as $flat)

    <div class="mb-2">

        <!-- Show Flat -->
        <span class="badge bg-secondary me-1">
            🏠 {{ $flat->flat_no }}
        </span>

        <!-- Show Parking Slots of this Flat -->
        @if($flat->parkingLots->count() > 0)

            @foreach($flat->parkingLots as $parking)

                <span class="badge bg-info text-dark me-1">
                    🚗 {{ $parking->parking_no }} ({{ $parking->type }})
                </span>

            @endforeach

        @else
            <span class="badge bg-light text-muted">
                No Parking
            </span>
        @endif

    </div>

@endforeach
</div>

                    </div>
                @endforeach

            </div>
        @empty
            <p class="text-muted">No tower data available</p>
        @endforelse
    </div>
</div>




@endsection

@push('scripts')
<script>
let floorIndex = 0;

function addFloor() {
    const wrapper = document.getElementById('floor-wrapper');

    const html = `
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between">
            <strong>Floor</strong>
            <button type="button" class="btn btn-sm btn-danger"
                onclick="this.closest('.card').remove()">❌</button>
        </div>

        <div class="card-body">
            <input type="number"
                name="floors[${floorIndex}][floor_no]"
                class="form-control mb-2"
                placeholder="Floor No (1,2,3)"
                required>

            <div class="flat-wrapper mb-2"></div>

            <button type="button"
                class="btn btn-sm btn-secondary"
                onclick="addFlat(this, ${floorIndex})">
                ➕ Add Flat
            </button>
        </div>
    </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
    floorIndex++;
}

function addFlat(btn, floorIndex) {
    const wrapper = btn.previousElementSibling;

    const html = `
    <div class="border p-2 mb-2">

        <div class="input-group mb-2">
            <input type="text"
                name="floors[${floorIndex}][flats][]"
                class="form-control"
                placeholder="Flat No (1A, 1B)"
                required>

            <button type="button"
                class="btn btn-danger"
                onclick="this.closest('.border').remove()">❌</button>
        </div>

        <div class="parking-wrapper"></div>

        <button type="button"
            class="btn btn-sm btn-info mt-1"
            onclick="addParking(this, ${floorIndex})">
            ➕ Add Parking Slot
        </button>

    </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
}

function addParking(btn, floorIndex) {

    const wrapper = btn.previousElementSibling;

    const html = `
    <div class="input-group mb-2">
        <input type="text"
            name="floors[${floorIndex}][parking][]"
            class="form-control"
            placeholder="Parking No (P1, P2)"
            required>

        <select name="floors[${floorIndex}][parking_type][]"
            class="form-control">
            <option value="Car">Car</option>
            <option value="Bike">Bike</option>
        </select>

        <button type="button"
            class="btn btn-danger"
            onclick="this.parentElement.remove()">❌</button>
    </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
}



</script>
@endpush
