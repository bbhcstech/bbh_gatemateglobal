@extends('admin.layout.app')
@section('title','Edit Tower')

@section('content')
<div class="card">
    <div class="card-header">✏️ Edit Tower Structure</div>

    <div class="card-body">
        <form method="POST" action="{{ route('towers.update', $tower->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="fw-bold">Tower Name</label>
                <input type="text" name="tower_name"
                       value="{{ $tower->name }}"
                       class="form-control" required>
            </div>

            <div id="floor-wrapper">
                @foreach($tower->floors as $fIndex => $floor)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <strong>Floor</strong>
                            <button type="button"
                                class="btn btn-sm btn-danger"
                                onclick="this.closest('.card').remove()">❌</button>
                        </div>

                        <div class="card-body">
                            <input type="number"
                                name="floors[{{ $fIndex }}][floor_no]"
                                value="{{ $floor->floor_no }}"
                                class="form-control mb-2"
                                required>

                            <div class="flat-wrapper mb-2">
@foreach($floor->flats as $flat)

<div class="border p-2 mb-2">

    <div class="input-group mb-2">
        <input type="text"
            name="floors[{{ $fIndex }}][flats][]"
            value="{{ $flat->flat_no }}"
            class="form-control" required>

        <button type="button"
            class="btn btn-danger"
            onclick="this.closest('.border').remove()">❌</button>
    </div>

    <div class="parking-wrapper">

        @foreach($flat->parkingLots as $pIndex => $parking)

        <div class="input-group mb-2">

            <input type="text"
                name="floors[{{ $fIndex }}][parking][]"
                value="{{ $parking->parking_no }}"
                class="form-control"
                required>

            <select name="floors[{{ $fIndex }}][parking_type][]"
                    class="form-control">

                <option value="Car"
                    {{ $parking->type == 'Car' ? 'selected' : '' }}>
                    Car
                </option>

                <option value="Bike"
                    {{ $parking->type == 'Bike' ? 'selected' : '' }}>
                    Bike
                </option>

            </select>

            <button type="button"
                class="btn btn-danger"
                onclick="this.parentElement.remove()">❌</button>

        </div>

        @endforeach

    </div>

    <button type="button"
        class="btn btn-sm btn-info mt-1"
        onclick="addParking(this, {{ $fIndex }})">
        ➕ Add Parking Slot
    </button>

</div>

@endforeach
</div>



                            <button type="button"
                                class="btn btn-sm btn-secondary"
                                onclick="addFlat(this, {{ $fIndex }})">
                                ➕ Add Flat
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-primary mb-3" onclick="addFloor()">
                ➕ Add Floor
            </button>

            <br>

            <button class="btn btn-success">
                💾 Update Tower
            </button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // start from existing floor count
    let floorIndex = {{ $tower->floors->count() }};

    function addFloor() {
        const wrapper = document.getElementById('floor-wrapper');

        const html = `
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <strong>Floor</strong>
                <button type="button"
                    class="btn btn-sm btn-danger"
                    onclick="this.closest('.card').remove()">❌</button>
            </div>

            <div class="card-body">
                <input type="number"
                    name="floors[${floorIndex}][floor_no]"
                    class="form-control mb-2"
                    placeholder="Floor No"
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
        <div class="input-group mb-2">
            <input type="text"
                name="floors[${floorIndex}][flats][]"
                class="form-control"
                placeholder="Flat No (1A, 2B)"
                required>
            <button type="button"
                class="btn btn-danger"
                onclick="this.parentElement.remove()">❌</button>
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
            placeholder="Parking No"
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
