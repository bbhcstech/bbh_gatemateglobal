@extends('admin.layout.app')

@section('title','Parking Management')

@section('content')

<div class="card">
    <div class="card-header">🚗 Add Parking</div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('parking.store') }}">
            @csrf

            <div class="row">

                <div class="col-md-3">
                    <label>Tower</label>
                    <select name="tower_id" id="tower" class="form-control" required>
                        <option value="">Select Tower</option>
                        @foreach($towers as $tower)
                            <option value="{{ $tower->id }}">{{ $tower->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Floor</label>
                    <select name="floor_id" id="floor" class="form-control" required>
                        <option value="">Select Floor</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Flat</label>
                    <select name="flat_id" id="flat" class="form-control" required>
                        <option value="">Select Flat</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Parking No</label>
                    <input type="text" name="parking_no" class="form-control" required>
                </div>

                <div class="col-md-1">
                    <label>Type</label>
                    <select name="type" class="form-control">
                        <option>Car</option>
                        <option>Bike</option>
                    </select>
                </div>

            </div>

            <br>

            <button class="btn btn-success">Save Parking</button>

        </form>
    </div>
</div>


<div class="card mt-3">
<div class="card-header">Parking List</div>

<div class="card-body">

<table class="table table-bordered">
<tr>
<th>Tower</th>
<th>Floor</th>
<th>Flat</th>
<th>Parking No</th>
<th>Type</th>
<th>Action</th>
</tr>

@foreach($parkings as $p)
<tr>
<td>{{ $p->tower->name }}</td>
<td>{{ $p->floor->floor_no }}</td>
<td>{{ $p->flat->flat_no }}</td>
<td>{{ $p->parking_no }}</td>
<td>{{ $p->type }}</td>

<td>
<form method="POST" action="{{ route('parking.destroy',$p->id) }}">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm">Delete</button>
</form>
</td>

</tr>
@endforeach

</table>

</div>
</div>

@endsection



@push('scripts')

<script>

document.getElementById('tower').addEventListener('change', function(){

    fetch('/get-floors/' + this.value)
    .then(res => res.json())
    .then(data => {

        let floor = document.getElementById('floor');
        floor.innerHTML = '<option>Select Floor</option>';

        data.forEach(f=>{
            floor.innerHTML += `<option value="${f.id}">${f.floor_no}</option>`;
        });

    });

});

document.getElementById('floor').addEventListener('change', function(){

    fetch('/get-flats/' + this.value)
    .then(res => res.json())
    .then(data => {

        let flat = document.getElementById('flat');
        flat.innerHTML = '<option>Select Flat</option>';

        data.forEach(f=>{
            flat.innerHTML += `<option value="${f.id}">${f.flat_no}</option>`;
        });

    });

});

</script>

@endpush
