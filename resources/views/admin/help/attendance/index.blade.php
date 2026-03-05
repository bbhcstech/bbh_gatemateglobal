@extends('admin.layout.app')

@section('title', 'Help Attendance')

@section('content')
<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Help Attendance</h5>

        <a href="{{ route('help.attendance.create') }}" class="btn btn-primary btn-sm">
            ➕ Add Attendance
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Help ID</th>
                    <th>Date</th>
                    <th>Entry Time</th>
                    <th>Exit Time</th>
                </tr>
            </thead>

            <tbody>
                @forelse($attendance as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->help_id }}</td>
                        <td>{{ $row->date }}</td>
                        <td>{{ $row->entry_time }}</td>
                        <td>{{ $row->exit_time ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No attendance records found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
