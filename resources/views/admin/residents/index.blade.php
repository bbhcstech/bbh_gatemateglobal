@extends('admin.layout.app')

@section('title', 'Residents Management')

@section('content')
<div class="container-fluid">

    <a href="{{ route('dashboard') }}" class="btn btn-link mb-2">🏠 Home</a>

    <div class="card shadow-sm mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Residents Management</h5>
            @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('residents.create') }}" class="btn btn-primary btn-sm">
                + Add Resident
            </a>
             @endif
        </div>

        <div class="card-body">
            <table id="datatable" class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Flat Details</th>
                        <th>Contact</th>
                        <th>Type</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($residents as $resident)
                    <tr>
                        <td>{{ $resident->id }}</td>

                        <td>
                            <strong>{{ $resident->name }}</strong>
                        </td>

                        <td>
                           <div>
                <strong>Flat:</strong> {{ $resident->flat?->flat_no ?? '-' }} <br>
                <strong>Floor:</strong> {{ $resident->flat?->floor?->floor_no ?? '-' }} <br>
                <strong>Tower:</strong> {{ $resident->flat?->floor?->tower?->name ?? '-' }}
            </div>

                        </td>

                        <td>
                            {{ $resident->phone }} <br>
                            <small class="text-muted">{{ $resident->email }}</small>
                        </td>

                        <td>
                            <span class="badge bg-{{ $resident->type == 'owner' ? 'success' : 'info' }}">
                                {{ ucfirst($resident->type) }}
                            </span>
                        </td>

                        <td class="text-center">
                            <a class="btn btn-info btn-sm"
                               href="{{ route('residents.show',$resident->id) }}">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a class="btn btn-warning btn-sm"
                               href="{{ route('residents.edit',$resident->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                             @if(auth()->check() && auth()->user()->role === 'admin')

                            <form class="d-inline"
                                  method="POST"
                                  action="{{ route('residents.destroy',$resident->id) }}"
                                  onsubmit="return confirm('Delete this resident?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            
                             @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
