@extends('admin.layout.app')

@section('content')
<h4>Cab Entry / Exit</h4>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('info'))
<div class="alert alert-info">{{ session('info') }}</div>
@endif

<table class="table table-bordered">
<tr>
    <th>Flat</th>
    <th>Vehicle</th>
    <th>Status</th>
    <th>Action</th>
</tr>

@foreach($expected as $cab)
<tr>
    <td>{{ $cab->flat_no }}</td>
    <td>{{ $cab->vehicle_number }}</td>
    <td>
        <span class="badge 
            {{ $cab->status == 'expected' ? 'bg-warning' : 'bg-primary' }}">
            {{ strtoupper($cab->status) }}
        </span>
    </td>

   <td>
    @if($cab->status == 'expected')
        <form method="POST" action="{{ route('cab.entry.mark', $cab->id) }}">
            @csrf
            <button class="btn btn-success btn-sm">ENTRY</button>
        </form>

    @elseif($cab->status == 'inside')
        <form method="POST" action="{{ route('cab.exit.mark', $cab->id) }}">
            @csrf
            <button class="btn btn-danger btn-sm">EXIT</button>
        </form>
    @endif
</td>

</tr>
@endforeach
</table>
@endsection
