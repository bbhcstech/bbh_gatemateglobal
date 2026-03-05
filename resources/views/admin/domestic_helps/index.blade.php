@extends('admin.layout.app')

@section('title', 'Vehicle Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>My Domestic Help & Vendors</h5>
        <a href="{{ route('domestic-helps.create') }}" class="btn btn-sm btn-primary">
            ➕ Add
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Documents</th>
                    <th>Phone</th>
                    <th>Service</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($helpers as $h)
                <tr>
                    <td>
                        <span class="badge bg-info">
                            {{ ucfirst(str_replace('_',' ', $h->type)) }}
                        </span>
                    </td>
                    <td>{{ $h->name }}</td>
                    <td>
                    @if($h->image)
                        <img src="{{ asset($h->image) }}"
                             class="img-thumbnail"
                             style="max-height:120px">
                    @else
                        <span class="text-muted">No Photo</span>
                    @endif
                </td>

                    <td>
                        @if($h->documents)
                            <a href="{{ asset($h->documents) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">
                                📄 View Document
                            </a>
                        @else
                            <span class="text-muted">No Document</span>
                        @endif
                    </td>

                    <td>{{ $h->phone }}</td>
                    <td>{{ $h->service ?? '-' }}</td>
                    <td>
                        <form method="POST" action="{{ route('domestic-helps.destroy',$h) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
