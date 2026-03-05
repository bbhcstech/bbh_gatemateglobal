@extends('admin.layout.app')

@section('title', 'Home Page')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">👥 Visitor Management</h4>

        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'resident'|| auth()->user()->role === 'security')
            <a href="{{ route('visitors.create') }}" class="btn btn-primary">
                ➕ Add Visitor
            </a>
        @endif
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body table-responsive">

            <table id="visitorsTable" class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Resident</th>
                        <th>Arrival</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($visitors as $key => $visitor)
                    <tr>
                        <td>{{ $key+1 }}</td>

                        <td>
                            @if($visitor->image)
                                <img src="{{ asset('storage/'.$visitor->image) }}"
                                     class="rounded-circle border"
                                     width="45" height="45"
                                     style="cursor:pointer"
                                     onclick="previewImage('{{ asset('storage/'.$visitor->image) }}')">
                            @else
                                <span class="badge bg-secondary">N/A</span>
                            @endif
                        </td>

                        <td>{{ $visitor->name }}</td>
                        <td>{{ $visitor->phone }}</td>
                        <td>{{ $visitor->resident->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($visitor->expected_arrival)->format('d M Y, h:i A') }}</td>

                       <td>
                            @if($visitor->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($visitor->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>


                        <td class="text-center">

                        


                            {{-- Admin / Resident --}}
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'resident'|| auth()->user()->role === 'security')
                                <a href="{{ route('visitors.edit',$visitor->id) }}"
                                   class="btn btn-sm btn-warning">
                                    ✏️
                                </a>

                                <form action="{{ route('visitors.destroy',$visitor->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete visitor?')">
                                        🗑
                                    </button>
                                </form>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body text-center">
                <img id="previewImg" class="img-fluid rounded">
            </div>
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
        $('#visitorsTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[ 5, "desc" ]]
        });
    });

    function previewImage(src) {
        document.getElementById('previewImg').src = src;
        new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
    }
</script>
@endpush
