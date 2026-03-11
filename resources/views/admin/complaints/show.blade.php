{{-- resources/views/admin/complaints/show.blade.php --}}
@extends('admin.layout.app')

@section('title', 'Complaint Details')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Complaint Details #{{ $complaint->id }}</h5>
                    <a href="{{ route('complaints.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="150">Resident:</th>
                                    <td>{{ $complaint->resident->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Type:</th>
                                    <td>
                                        <span class="badge bg-secondary">{{ $complaint->type }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @php
                                            $badgeClass = match($complaint->status) {
                                                'Pending' => 'warning',
                                                'In Progress' => 'info',
                                                'Resolved' => 'success',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">{{ $complaint->status }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="150">Created:</th>
                                    <td>{{ $complaint->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $complaint->updated_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                @if($complaint->resolved_at)
                                <tr>
                                    <th>Resolved On:</th>
                                    <td>{{ $complaint->resolved_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6>Description:</h6>
                            <div class="p-3 bg-light rounded">
                                {{ $complaint->description }}
                            </div>
                        </div>
                    </div>

                    @if($complaint->status === 'Resolved' && auth()->user()->role !== 'admin')
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button class="btn btn-success btn-lg confirm-resolution"
                                    data-complaint-id="{{ $complaint->id }}">
                                <i class="fas fa-check-circle"></i> Confirm Problem Solved
                            </button>
                            <p class="text-muted mt-2">
                                Click to confirm that the problem has been resolved. This will close the ticket.
                            </p>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <a href="{{ route('complaints.edit', $complaint->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('complaints.destroy', $complaint->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this complaint?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.confirm-resolution').on('click', function() {
            if (!confirm('Have you confirmed that the problem is solved? This will close the ticket.')) {
                return;
            }

            var complaintId = $(this).data('complaint-id');

            $.ajax({
                url: '{{ url("complaints") }}/' + complaintId + '/confirm-resolution',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert('Thank you for confirming! This ticket will now be closed.');
                        window.location.href = '{{ route("complaints.index") }}';
                    } else {
                        alert(response.message || 'Error confirming resolution');
                    }
                },
                error: function() {
                    alert('Error confirming resolution');
                }
            });
        });
    });
</script>
@endpush
