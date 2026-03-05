@extends('admin.layout.app')

@section('title','Delivery')

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="container-fluid">

<div class="card shadow-sm">
<div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Delivery Pre-Approvals</h5>

    @if(auth()->user()->role === 'resident')
    <a href="{{ route('delivery.create') }}" class="btn btn-warning btn-sm">
        + Allow Delivery
    </a>
    @endif
</div>

<div class="card-body p-0">

<div class="table-responsive">
<table class="table table-hover align-middle mb-0">

<thead class="table-light">
<tr>
    <th>#</th>
    <th>Company</th>
    <th>Flat</th>
    <th>Type</th>
    <th>Time / Validity</th>
    <th>Status</th>
    <th class="text-center">Action</th>
</tr>
</thead>

<tbody>
@forelse($deliveries as $delivery)
<tr>

<td>{{ $loop->iteration }}</td>

<td>
    <strong>{{ $delivery->delivery_company_name }}</strong>
    @if($delivery->surprise_delivery)
        <span class="badge bg-danger ms-1">Surprise</span>
    @endif
</td>

<td>{{ $delivery->flat_no }}</td>

<td>
    <span class="badge bg-info text-dark text-capitalize">
        {{ str_replace('_',' ', $delivery->type) }}
    </span>
</td>

<td>
@if($delivery->type === 'one_time')
    {{ $delivery->expected_time }} mins
@else
    {{ ucfirst($delivery->days_of_week) }}<br>
    {{ $delivery->time_from }} – {{ $delivery->time_to }}<br>
    {{ $delivery->validity_months }} Month(s)
@endif
</td>

<td>
@if($delivery->status === 'expected')
    <span class="badge bg-warning">Expected</span>
@elseif($delivery->status === 'inside')
    <span class="badge bg-primary">Inside</span>
@elseif($delivery->status === 'completed')
    <span class="badge bg-success">Completed</span>
@endif
</td>

<td class="text-center">

{{-- SECURITY ACTIONS --}}
@if(auth()->user()->role === 'security')

    @if($delivery->status === 'expected')
        <a href="{{ route('delivery.entry', $delivery->id) }}"
           class="btn btn-success btn-sm">
           ENTRY
        </a>
    @elseif($delivery->status === 'inside')
        <a href="{{ route('delivery.exit', $delivery->id) }}"
           class="btn btn-danger btn-sm">
           EXIT
        </a>
    @endif

{{-- RESIDENT / ADMIN VIEW --}}
@else
    <span class="text-muted">—</span>
@endif

</td>

</tr>
@empty
<tr>
<td colspan="7" class="text-center text-muted py-4">
    No delivery records found
</td>
</tr>
@endforelse

</tbody>

</table>
</div>

</div>
</div>
</div>

@endsection
