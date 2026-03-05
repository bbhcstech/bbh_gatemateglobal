@extends('admin.layout.app')

@section('title', 'Delivery Entry')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark fw-bold">
        🚚 Delivery Entry / Exit
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Resident</th>
                    <th>Flat</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Timing</th>
                    <th width="160">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($expected as $i => $d)
                    <tr>
                        <td class="text-center">{{ $i+1 }}</td>

                        <td>
                            {{ optional($d->resident)->name }}<br>
                            <small class="text-muted">
                                📞 {{ optional($d->resident)->mobile }}
                            </small>
                        </td>

                        <td class="text-center">
                            {{ $d->flat_no ?? '-' }}
                        </td>

                        <td>
                            <strong>{{ $d->delivery_company_name }}</strong><br>
                            <small>{{ $d->delivery_person_name }}</small>
                        </td>

                        <td class="text-center">
                            <span class="badge bg-info text-uppercase">
                                {{ $d->type }}
                            </span>
                        </td>

                        <td class="text-center">
                            @if($d->status == 'expected')
                                <span class="badge bg-warning">Expected</span>
                            @elseif($d->status == 'inside')
                                <span class="badge bg-primary">Inside</span>
                            @else
                                <span class="badge bg-success">Completed</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($d->type === 'one_time')
                                {{ $d->expected_time }} mins
                            @else
                                {{ $d->time_from }} - {{ $d->time_to }}
                            @endif
                        </td>

                        <td class="text-center">
                            @if($d->status === 'expected')
                                <a href="{{ route('delivery.entry', $d->id) }}"
                                   class="btn btn-sm btn-success">
                                    Entry
                                </a>
                            @elseif($d->status === 'inside')
                                <a href="{{ route('delivery.exit', $d->id) }}"
                                   class="btn btn-sm btn-danger">
                                    Exit
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No delivery records found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
