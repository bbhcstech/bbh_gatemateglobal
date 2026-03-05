@extends('admin.layout.app')

@section('title', 'Security Guards')

@section('content')
<div class="container-fluid">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Security Guards Management</h5>

            <a href="{{ route('security-guards.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Security Guard
            </a>
        </div>

        <div class="card-body table-responsive">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

          <table id="guardsTable" class="table table-bordered table-hover align-middle">
    <thead class="table-light">
                    <tr>
                        <th width="50">ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Contact</th>
                        <th>Shift</th>
                        <th>Status</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($guards as $guard)
                    <tr>
                        <td>{{ $guard->id }}</td>

                        <td>
                            <strong>{{ $guard->first_name }} {{ $guard->last_name }}</strong><br>
                            <small class="text-muted">{{ $guard->email }}</small>
                        </td>

                        <td>{{ $guard->username }}</td>

                        <td>{{ $guard->phone }}</td>

                        <td>
                            <span class="badge bg-info">
                                {{ ucfirst($guard->shift) }}
                            </span>
                        </td>

                        <td>
                            @if($guard->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <!-- View -->
                            <a href="{{ route('security-guards.show',$guard->id) }}"
                               class="btn btn-sm btn-info text-white"
                               title="View">
                                <i class="fas fa-eye"></i>
                            </a>

                            <!-- Disable -->
                            <a href="{{ route('security-guards.toggle',$guard->id) }}"
                               class="btn btn-sm btn-warning"
                               title="Disable">
                                <i class="fas fa-ban"></i>
                            </a>

                            <!-- Reset Password -->
                            <a href="{{ route('security-guards.reset',$guard->id) }}"
                               class="btn btn-sm btn-secondary"
                               title="Reset Password">
                                <i class="fas fa-key"></i>
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('security-guards.edit',$guard->id) }}"
                               class="btn btn-sm btn-primary"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('security-guards.destroy',$guard->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="7" class="text-center text-muted">
                            No security guards found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

           
        </div>
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

