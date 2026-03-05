@extends('admin.layout.app')

@section('content')
<h4>My Cab Requests</h4>
 @if(auth()->user()->role == 'resident')
<a href="{{ route('cab.create') }}" class="btn btn-primary mb-2">
Add Cab
</a>
@endif

<table class="table table-bordered">
<tr>
<th>Company</th><th>Flat No</th><th>Vehicle</th><th>Status</th><th>Time</th>
</tr>

@foreach($cabs as $cab)
<tr>
<td>{{ $cab->company_name }}</td>
<td>{{ $cab->flat_no }}</td>
<td>{{ $cab->vehicle_number }}</td>
<td>
    @if($cab->status === 'expected')
        <span class="badge bg-warning">Pending</span>
    @elseif($cab->status === 'inside')
        <span class="badge bg-primary">Inside</span>
    @elseif($cab->status === 'completed')
        <span class="badge bg-success">Completed</span>
    @else
        <span class="badge bg-danger">Cancelled</span>
    @endif
</td>

<td>
    @if($cab->type === 'one_time')
        {{ $cab->expected_time }} minutes
    @else
        {{ \Carbon\Carbon::parse($cab->time_from)->format('h:i A') }}
        –
        {{ \Carbon\Carbon::parse($cab->time_to)->format('h:i A') }}
    @endif
</td>

</tr>
@endforeach
</table>
@endsection
