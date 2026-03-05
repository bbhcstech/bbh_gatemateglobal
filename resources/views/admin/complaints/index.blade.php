@extends('admin.layout.app')

@section('title','Complaints')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">Complaints</h5>
            <a href="{{ route('complaints.create') }}" class="btn btn-primary btn-sm">+ Raise Complaint</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="complaintsTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Resident</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $complaint)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $complaint->resident->name ?? '-' }}</td>
                            <td>{{ $complaint->type }}</td>
                            <td>{{ $complaint->description }}</td>
                            <td>
                                @if(auth()->user()->role === 'admin')
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#statusModal{{ $complaint->id }}">
                                        <span class="badge bg-{{ $complaint->status == 'Pending' ? 'warning' : ($complaint->status == 'In Progress' ? 'info' : 'success') }}">
                                            {{ $complaint->status }}
                                        </span>
                                    </a>
                                @else
                                    <span class="badge bg-{{ $complaint->status == 'Pending' ? 'warning' : ($complaint->status == 'In Progress' ? 'info' : 'success') }}">
                                        {{ $complaint->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('complaints.edit', $complaint->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>

                                <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this complaint?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                     
                        
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Status Modals -->
    @foreach($complaints as $complaint)
    <div class="modal fade" id="statusModal{{ $complaint->id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $complaint->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('complaints.updateStatus', $complaint->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel{{ $complaint->id }}">Update Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            @foreach(['Pending','In Progress','Resolved'] as $status)
                                <option value="{{ $status }}" {{ $complaint->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach

</div>
@endsection

@push('scripts')
<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap 5 JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#complaintsTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[0, "desc"]]
        });
    });
</script>
@endpush
