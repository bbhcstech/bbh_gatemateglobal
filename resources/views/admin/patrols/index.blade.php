
@extends('admin.layout.app')

@section('title','Patrol Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Patrol Management</h5>

        <div class="d-flex gap-2">
            <form method="GET">
                <input type="date" name="date" value="{{ $date }}" class="form-control form-control-sm">
            </form>

            <a href="{{ route('patrols.create') }}" class="btn btn-primary btn-sm">
                ➕ Add Patrol Log
            </a>
        </div>
    </div>

    <div class="card-body">
          <table id="guardsTable" class="table table-bordered table-hover align-middle">
    <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Guard</th>
                    <th>Zone</th>
                    <th>Time</th>
                    <th>Checkpoints</th>
                    <th>Status</th>
                    <th width="160">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($patrols as $patrol)
            <tr>
                <td>{{ $patrol->id }}</td>
            
                <td>
                    {{ $patrol->securityGuard?->name ?? 'Not Assigned' }}
                </td>
            
                <td>
                    {{ $patrol->zone?->name ?? '—' }}
                </td>
            
                <td>
                    {{ \Carbon\Carbon::parse($patrol->start_time)->format('d M Y h:i A') }}
                    <br>
                    <small>
                        {{ $patrol->end_time
                            ? \Carbon\Carbon::parse($patrol->end_time)->format('d M Y h:i A')
                            : '-' }}
                    </small>
                </td>
            
                <td>{{ $patrol->checkpoints }}</td>
            
                <td>
                    <span class="badge bg-info">{{ $patrol->status }}</span>
                </td>
                
                <td class="text-center">
            <!-- View -->
            <a href="{{ route('patrols.show',$patrol->id) }}"
               class="btn btn-sm btn-info text-white"
               title="View">
                <i class="fas fa-eye"></i>
            </a>
        
            <!-- Edit -->
            <a href="{{ route('patrols.edit',$patrol->id) }}"
               class="btn btn-sm btn-primary"
               title="Edit">
                <i class="fas fa-edit"></i>
            </a>
        
            <!-- Delete -->
            <form action="{{ route('patrols.destroy',$patrol->id) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Delete this patrol?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No data available</td>
            </tr>
            @endforelse
            </tbody>

        </table>

     
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function () {
    $('#guardsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        ordering: true,
        searching: true,
        responsive: true,
        columnDefs: [
            { orderable: false, targets: [6] } // Disable sorting on Actions
        ]
    });
});
</script>
@endpush
