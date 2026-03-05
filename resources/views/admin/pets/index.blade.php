@extends('admin.layout.app')

@section('title','Pets')

@section('content')
<div class="container-fluid">

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">Pet List</h5>
        <a href="{{ route('pets.create') }}" class="btn btn-primary btn-sm">
            + Add Pet
        </a>
    </div>

    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Color</th>
                    <th>Image</th>
                    <!--<th>Resident</th>-->
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pets as $pet)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span class="badge bg-info">
                            {{ $pet->type ?? '-' }}
                        </span>
                    </td>
                    
                    <td>{{ $pet->name }}</td>

                    <td>{{ $pet->age ?? '-' }}</td>
                    <td>{{ $pet->color ?? '-' }}</td>
                    <td>
    @if($pet->image)
        <img src="{{ asset($pet->image) }}"
             width="50" height="50"
             class="rounded-circle">
    @else
        -
    @endif
</td>

                    <!--<td>{{ $pet->resident->name ?? '-' }}</td>-->
                     <td class="text-center">
                        <!-- Edit -->
                        <a href="{{ route('pets.edit', $pet->id) }}"
                           class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Delete -->
                        <form action="{{ route('pets.destroy', $pet->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this pet?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No pets found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>
@endsection
