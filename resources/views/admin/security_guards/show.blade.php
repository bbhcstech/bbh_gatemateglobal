@extends('admin.layout.app')

@section('title','View Security Guard')

@section('content')
<div class="container-fluid">

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Security Guard Details</h5>
            <a href="{{ route('security-guards.index') }}" class="btn btn-secondary btn-sm">
                ← Back
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Name</th>
                    <td>{{ $guard->first_name }} {{ $guard->last_name }}</td>
                </tr>

                <tr>
                    <th>Username</th>
                    <td>{{ $guard->username }}</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ $guard->email ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Phone</th>
                    <td>{{ $guard->phone ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Shift</th>
                    <td>
                        <span class="badge bg-info text-capitalize">
                            {{ $guard->shift }}
                        </span>
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($guard->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Created At</th>
                    <td>{{ $guard->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>
        </div>
    </div>

</div>
@endsection
