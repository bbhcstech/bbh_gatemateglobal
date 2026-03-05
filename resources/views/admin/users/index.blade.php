@extends('admin.layout.app')

@section('title', 'Users')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>User Management</h5>
        <!--<a href="{{ route('users.creates') }}" class="btn btn-primary btn-sm">-->
        <!--    + Add User-->
        <!--</a>-->
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
    <table class="table table-bordered align-middle w-100" id="usersTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile No</th>
                    <th>Documents</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th width="120">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>
                    <td>{{ $user->mobile }}</td>
                     <td>@if($user->document && $user->document->file_path)
            <a href="{{ asset($user->document->file_path) }}" target="_blank">
                View
            </a>
        @else
            No Document
        @endif</td>

                                <td class="text-capitalize">
                                    {{ $user->roleMaster->role_name ?? 'N/A' }}
                                </td>
               
                    {{-- STATUS --}}
                <td>
                    @if($user->approval_status === 'pending')
                        <span class="badge bg-warning text-dark">⏳ Pending</span>
                    @elseif($user->approval_status === 'approved')
                        <span class="badge bg-success">✔ Approved</span>
                        <br>
                        <span class="badge bg-{{ $user->is_active === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($user->is_active) }}
                        </span>
                    @else
                        <span class="badge bg-danger">❌ Rejected</span>
                    @endif
                </td>
                
                {{-- ACTION --}}
                <td>
@if(auth()->user()->role === 'admin')
    <div class="btn-group btn-group-sm">

        {{-- PENDING --}}
        @if($user->approval_status === 'pending')
            <form action="{{ route('users.approve', $user->id) }}" method="POST">
                @csrf
                <button class="btn btn-success" title="Approve">✔</button>
            </form>

            <form action="{{ route('users.reject', $user->id) }}"
                  method="POST"
                  onsubmit="return confirm('Reject this user?')">
                @csrf
                <button class="btn btn-danger" title="Reject">✖</button>
            </form>
        @endif

        {{-- APPROVED (REVERSE OPTION ADDED) --}}
        @if($user->approval_status === 'approved')
            <form action="{{ route('users.toggle', $user->id) }}" method="POST">
                @csrf
                <button
                    class="btn btn-{{ $user->is_active === 'active' ? 'danger' : 'success' }}"
                    title="{{ $user->is_active === 'active' ? 'Deactivate' : 'Activate' }}">
                    {{ $user->is_active === 'active' ? '⛔' : '✔' }}
                </button>
            </form>

            {{-- 🔴 NEW: REJECT AFTER APPROVAL --}}
            <form action="{{ route('users.reject', $user->id) }}"
                  method="POST"
                  onsubmit="return confirm('Rejecting will deactivate user and remove resident. Continue?')">
                @csrf
                <button class="btn btn-outline-danger" title="Reject User">✖</button>
            </form>
        @endif

        {{-- REJECTED (OPTIONAL RE-APPROVE) --}}
        @if($user->approval_status === 'rejected')
            <form action="{{ route('users.approve', $user->id) }}" method="POST">
                @csrf
                <button class="btn btn-success" title="Re-Approve">✔</button>
            </form>
        @endif

    </div>

    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">
        👁 View
    </a>
@endif
</td>


                @endforeach
            </tbody>

        </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#usersTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[ 0, "desc" ]]
        });
    });

    function previewImage(src) {
        document.getElementById('previewImg').src = src;
        new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
    }
</script>
@endpush