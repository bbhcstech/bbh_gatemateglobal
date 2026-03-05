@extends('admin.layout.app')

@section('content')
<h4>Vendor Visits</h4>
<a href="{{ route('vendor-visits.create') }}" class="btn btn-primary mb-3">Add Visit</a>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>Vendor</th>
            <th>Resident</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($visits as $visit)
        <tr>
            <td>{{ $visit->vendor->name }}</td>
            <td>{{ $visit->resident->name }}</td>
            <td>{{ $visit->visit_date }}</td>
            <td>{{ $visit->time }}</td>
            <td>{{ $visit->status }}</td>
            <td>
                <a href="{{ route('vendor-visits.edit',$visit->visit_id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form method="POST" action="{{ route('vendor-visits.destroy',$visit->visit_id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No visits found</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
