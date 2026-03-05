@extends('admin.layout.app')

@section('title', 'Visitor Pre-Approvals')

@section('content')
<div class="container">
    <div class="card shadow-sm">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3 p-3">
            <h5 class="mb-0">Visitor Pre-Approval List</h5>

            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'resident')
                <a href="{{ route('visitor-preapproval.create') }}" class="btn btn-primary">
                    ➕ Add Visitor Pre-Approval
                </a>
            @endif
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Visitor Name</th>
                        <th>Phone</th>
                        <th>Purpose</th>
                        <th>Image</th>
                        <th>Resident</th>
                        <th>Visit Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($approvals as $key => $approval)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>{{ $approval->name ?? '-' }}</td>

                            <td>{{ $approval->phone ?? '-' }}</td>

                            <td>{{ $approval->purpose ?? '-' }}</td>

                            <td>
                                @if($approval->image)
                                    <img src="{{ asset($approval->image) }}"
                                         width="50" height="50"
                                         class="rounded">
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ $approval->resident->name ?? '-' }}</td>

                            <td>{{ $approval->visit_date }}</td>

                            <td>{{ $approval->expected_time }}</td>

                            {{-- Status --}}
                            <td>
                                <span class="badge 
                                    @if($approval->status == 'pending') bg-warning
                                    @elseif($approval->status == 'approved') bg-success
                                    @elseif($approval->status == 'rejected') bg-danger
                                    @else bg-secondary
                                    @endif
                                ">
                                    {{ ucfirst($approval->status) }}
                                </span>
                            </td>

                            {{-- Action --}}
                            <td class="text-center">

                                @if(auth()->check() && auth()->user()->role === 'security')

                                    @if($approval->status === 'pending')

                                        <form action="{{ route('visitor-preapproval.approve', $approval->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('PUT')

                                            <button class="btn btn-sm btn-success">
                                                Approve
                                            </button>
                                        </form>

                                    @else
                                        <span class="text-muted">—</span>
                                    @endif

                                @else
                                    <span class="text-muted">—</span>
                                @endif
                                
                                                      {{-- EDIT BUTTON --}}
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'resident')
                            <a href="{{ route('visitor-preapproval.edit', $approval->id) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endif
                    
                    
                        {{-- DELETE BUTTON --}}
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'resident')
                    
                            <form action="{{ route('visitor-preapproval.destroy', $approval->id) }}" 
                                  method="POST" 
                                  style="display:inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this record?');">
                    
                                @csrf
                                @method('DELETE')
                    
                                <button type="submit" class="btn btn-sm btn-danger">
                                     <i class="fas fa-trash"></i>
                                </button>
                    
                            </form>
                    
                        @endif

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                No pre-approvals found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
