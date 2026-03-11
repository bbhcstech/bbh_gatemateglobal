@extends('admin.layout.app')

@section('title', 'Resident Profile')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Resident Profile</h3>
                    <a href="{{ route('residents.index') }}" class="btn btn-sm btn-primary float-end">Back to Residents</a>
                </div>
                <div class="card-body">
                    @if(isset($resident))
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Name</th>
                                        <td>{{ $resident->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $resident->email ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $resident->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td>{{ $resident->type ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tower</th>
                                        <td>{{ $resident->tower->tower_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Floor</th>
                                        <td>{{ $resident->floor->floor_no ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Flat</th>
                                        <td>{{ $resident->flat->flat_no ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <h4 class="mt-4">Pets ({{ $pets->count() ?? 0 }})</h4>
                        @if(isset($pets) && $pets->count() > 0)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Breed</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pets as $pet)
                                    <tr>
                                        <td>{{ $pet->pet_name }}</td>
                                        <td>{{ $pet->pet_type }}</td>
                                        <td>{{ $pet->pet_breed ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $pet->activity_status ? 'success' : 'danger' }}">
                                                {{ $pet->activity_status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">No pets found for this resident.</p>
                        @endif
                    @else
                        <div class="alert alert-danger">Resident not found!</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
