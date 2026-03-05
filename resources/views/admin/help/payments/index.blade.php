@extends('admin.layout.app')

@section('title', 'Help Payments')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>💰 Help Payments</h5>
        <a href="{{ route('help.payments.create') }}" class="btn btn-primary btn-sm">
            ➕ Add Payment
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Amount</th>
                    <th>Mode</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $payment->name }}</td>
                        <td>{{ $payment->mobile }}</td>
                        <td>₹ {{ $payment->amount }}</td>
                        <td>{{ ucfirst($payment->payment_mode) }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No payments found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection
