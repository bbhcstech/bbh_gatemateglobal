@extends('admin.layout.app')

@section('title','Family Members')

@section('content')
<div class="container-fluid">

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">Family Members</h5>
        <a href="{{ route('family-members.create') }}" class="btn btn-primary btn-sm">
            + Add Family Member
        </a>
    </div>

    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Relation</th>
                    <th>Mobile</th>
                    @if(auth()->user()->role === 'admin')
                        <th>Resident</th>
                    @endif
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($familyMembers as $member)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $member->name }}</td>
                   <td>{{ $member->relation->name ?? '-' }}</td>

                    <td>{{ $member->mobile ?? '-' }}</td>

                    @if(auth()->user()->role === 'admin')
                        <td>{{ $member->resident->name ?? '-' }}</td>
                    @endif

                    <td class="text-center">
                        <a href="{{ route('family-members.edit',$member) }}"
                           class="btn btn-warning btn-sm">
                           <i class="fas fa-edit"></i>
                        </a>

                        <form method="POST" class="d-inline"
                              action="{{ route('family-members.destroy',$member) }}"
                              onsubmit="return confirm('Delete?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No family members found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>
@endsection
