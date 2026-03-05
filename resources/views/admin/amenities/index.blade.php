@extends('admin.layout.app')

@section('title','Amenity Management')

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Amenity Management</h5>

        <a href="{{ route('amenities.create') }}" class="btn btn-primary btn-sm">
            ➕ Add Amenity
        </a>
    </div>

    <div class="card-body">
        <table id="amenitiesTable" class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Capacity</th>
                    <th>Booking Fee</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($amenities as $amenity)
                <tr>
                    <td>{{ $amenity->id }}</td>
                    <td>{{ $amenity->name }}</td>
                    <td>{{ $amenity->location }}</td>
                    <td>{{ $amenity->capacity }}</td>
                    <td>₹{{ number_format($amenity->booking_fee, 2) }}</td>

                    <td>
                        <span class="badge {{ $amenity->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $amenity->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td class="text-center">
                        <!-- View -->
                        <a href="{{ route('amenities.show', $amenity->id) }}"
                           class="btn btn-info btn-sm">
                            👁
                        </a>

                        <!-- Edit -->
                        <a href="{{ route('amenities.edit', $amenity->id) }}"
                           class="btn btn-warning btn-sm">
                            ✏️
                        </a>

                        <!-- Toggle Status -->
                        <form action="{{ route('amenities.status', $amenity->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-secondary btn-sm">
                                ❌
                            </button>
                        </form>

                        <!-- Delete -->
                        <form action="{{ route('amenities.destroy', $amenity->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                🗑
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#amenitiesTable').DataTable();
});
</script>
