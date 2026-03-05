@extends('admin.layout.app')

@section('title', 'Help Payments')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Help Ratings</h5>
        <a href="{{ route('help-ratings.create') }}" class="btn btn-primary btn-sm">Add Rating</a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Help ID</th>
                    <th>Resident ID</th>
                    <th>Rating</th>
                    <th>Feedback</th>
                    <th width="120">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ratings as $rating)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $rating->help_id }}</td>
                    <td>{{ $rating->resident_id }}</td>
                    <td>{{ $rating->rating }}/5</td>
                    <td>{{ $rating->feedback }}</td>
                    <td>
                        <!--<a href="{{ route('help-ratings.edit',$rating->rating_id) }}" class="btn btn-warning btn-sm">✏️</a>-->
                        <form action="{{ route('help-ratings.destroy',$rating->rating_id) }}"
                              method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">🗑️</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
